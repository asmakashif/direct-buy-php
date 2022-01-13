// Global key for canMakepayment cache.
const canMakePaymentCache = 'canMakePaymentCache';

/**
 * Read data for supported instruments from input from.
 */
function readSupportedInstruments() {
  let formValue = {};
  formValue['pa'] = document.getElementById('pa').value;
  formValue['pn'] = document.getElementById('pn').value;
  formValue['tn'] = document.getElementById('tn').value;
  formValue['mc'] = document.getElementById('mc').value;
  formValue['tr'] = document.getElementById('tr').value;
  formValue['tid'] = document.getElementById('tid').value;
  formValue['url'] = document.getElementById('url').value;
  return formValue;
}

/**
 * Read the amount from input form.
 */
function readAmount() {
  return document.getElementById('amount').value;
}

/**
 * Launches payment request.
 */
function onBuyClicked() {
  if (!window.PaymentRequest) {
    console.log('Web payments are not supported in this browser.');
    return;
  }

  let formValue = readSupportedInstruments();

  const supportedInstruments = [
    {
      supportedMethods: ['https://pwp-server.appspot.com/pay-dev'],
      data: formValue,
    },
    {
      supportedMethods: ['https://tez.google.com/pay'],
      data: formValue,
    },
  ];

  const details = {
    total: {
      label: 'Total',
      amount: {
        currency: 'INR',
        value: readAmount(),
      },
    },
    displayItems: [
      {
        label: 'Original amount',
        amount: {
          currency: 'INR',
          value: readAmount(),
        },
      },
    ],
  };

  let request = null;
  try {
    request = new PaymentRequest(supportedInstruments, details);
  } catch (e) {
    console.log('Payment Request Error: ' + e.message);
    return;
  }
  if (!request) {
    console.log('Web payments are not supported in this browser.');
    return;
  }


  var canMakePaymentPromise = checkCanMakePayment(request);
  canMakePaymentPromise
      .then((result) => {
        showPaymentUI(request, result);
      })
      .catch((err) => {
        console.log('Error calling checkCanMakePayment: ' + err);
      });
}

/**
 * Checks whether can make a payment with Tez on this device. It checks the
 * session storage cache first and uses the cached information if it exists.
 * Otherwise, it calls canMakePayment method from the Payment Request object and
 * returns the result. The result is also stored in the session storage cache
 * for future use.
 *
 * @private
 * @param {PaymentRequest} request The payment request object.
 * @return {Promise} a promise containing the result of whether can make payment.
 */
function checkCanMakePayment(request) {
  // Checks canMakePayment cache, and use the cache result if it exists.
  if (sessionStorage.hasOwnProperty(canMakePaymentCache)) {
    return Promise.resolve(JSON.parse(sessionStorage[canMakePaymentCache]));
  }

  // If canMakePayment() isn't available, default to assuming that the method is
  // supported.
  var canMakePaymentPromise = Promise.resolve(true);

  // Feature detect canMakePayment().
  if (request.canMakePayment) {
    canMakePaymentPromise = request.canMakePayment();
  }

  return canMakePaymentPromise
      .then((result) => {
        // Store the result in cache for future usage.
        sessionStorage[canMakePaymentCache] = result;
        return result;
      })
      .catch((err) => {
        console.log('Error calling canMakePayment: ' + err);
      });
}

/**
 * Show the payment request UI.
 *
 * @private
 * @param {PaymentRequest} request The payment request object.
 * @param {Promise} canMakePayment The promise for whether can make payment.
 */
function showPaymentUI(request, canMakePayment) {
  // Redirect to play store if can't make payment.
  if (!canMakePayment) {
    redirectToPlayStore();
    return;
  }

  // Set payment timeout.
  let paymentTimeout = window.setTimeout(function() {
    window.clearTimeout(paymentTimeout);
    request.abort()
        .then(function() {
          console.log('Payment timed out after 20 minutes.');
        })
        .catch(function() {
          console.log('Unable to abort, user is in the process of paying.');
        });
  }, 20 * 60 * 1000); /* 20 minutes */

  request.show()
      .then(function(instrument) {
        window.clearTimeout(paymentTimeout);
        processResponse(instrument);  // Handle response from browser.
      })
      .catch(function(err) {
        console.log(err);
      });
}

/**
 * Process the response from browser.
 *
 * @private
 * @param {PaymentResponse} instrument The payment instrument that was authed.
 */
function processResponse(instrument) {
  var instrumentString = instrumentToJsonString(instrument);
  console.log(instrumentString);

  fetch('/buy', {
    method: 'POST',
    headers: new Headers({'Content-Type': 'application/json'}),
    body: instrumentString,
    credentials: 'include',
  })
      .then(function(buyResult) {
        if (buyResult.ok) {
          return buyResult.json();
        }
        console.log('Error sending instrument to server.');
      })
      .then(function(buyResultJson) {
        completePayment(
            instrument, buyResultJson.status, buyResultJson.message);
      })
      .catch(function(err) {
        console.log('Unable to process payment. ' + err);
      });
}

/**
 * Notify browser that the instrument authorization has completed.
 *
 * @private
 * @param {PaymentResponse} instrument The payment instrument that was authed.
 * @param {string} result Whether the auth was successful. Should be either
 * 'success' or 'fail'.
 * @param {string} msg The message to log in console.
 */
function completePayment(instrument, result, msg) {
  instrument.complete(result)
      .then(function() {
        console.log('Payment completes.');
        console.log(msg);
        document.getElementById('inputSection').style.display = 'none'
        document.getElementById('outputSection').style.display = 'block'
        document.getElementById('response').innerHTML =
            JSON.stringify(instrument, undefined, 2);
      })
      .catch(function(err) {
        console.log(err);
      });
}

/** Redirect to PlayStore. */
function redirectToPlayStore() {
  if (confirm('Tez not installed, go to play store and install?')) {
    window.location.href =
        'https://play.google.com/store/apps/details?id=com.google.android.apps.nbu.paisa.user.alpha'
  };
}


/**
 * Converts the payment instrument into a JSON string.
 *
 * @private
 * @param {PaymentResponse} instrument The instrument to convert.
 * @return {string} The string representation of the instrument.
 */
function instrumentToJsonString(instrument) {
  // PaymentResponse is an interface, JSON.stringify works only on dictionaries.
  var instrumentDictionary = {
    methodName: instrument.methodName,
    details: instrument.details,
    shippingAddress: addressToJsonString(instrument.shippingAddress),
    shippingOption: instrument.shippingOption,
    payerName: instrument.payerName,
    payerPhone: instrument.payerPhone,
    payerEmail: instrument.payerEmail,
  };
  return JSON.stringify(instrumentDictionary, undefined, 2);
}
