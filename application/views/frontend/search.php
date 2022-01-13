
    
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


 


 <div class="container">
  
   <!-- <script src="jquery-3.1.1.min.js"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <script>
     $(function(){
      $("#user-input").autocomplete({
        source: "<?php echo base_url('welcome/user_search'); ?>",
        minLength: 1
      });
    });
    </script> 
 <input id="user-input" type="text" name="users" placeholder="Search User">



