jQuery('document').ready(function(){
  
  jQuery(function($){
    $('#subscribe-btn').click(function(){
        var email     = $('#email_sender').val();
        var phone     = $('#subscribe-phone').val();
        var ajaxUrl   = $('#admin-ajax').val();
      
      if(phone===''){
        alert('The field is empty ! please populate it .');
        return ;
      }
      //Send mail to notify admin while someone subscribe
        var action    = 'send_email' ;
        $.ajax({
            url   :ajaxUrl,
            data  :{'action':action,'phone':phone,'email_sender':email},
            type  :'POST', // POST
            success:function(data){
                console.log(data);
            }
        });
      
         //Insert a row in subscribe field post type
        action = 'insert_subscribe_field' ;
        $.ajax({
            url   :ajaxUrl,
            data  :{'action':action,'phone':phone,'email_sender':email},
            type  :'POST', // POST
            success:function(data){
                console.log(data);
            }
        });
       
      //Strip
       $('#subscribe-phone').val('');
      
        return false;
    });
});
  
  
});