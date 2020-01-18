(function( $ ) {

	$(function() {

       
       

       if (jQuery('.pcfme-datepicker').length) {
		 jQuery('.pcfme-datepicker').datetimepicker({
           format:'d/m/Y',
           timepicker:false
       });
	   }
	   var dateToday = new Date(); 
	   if (jQuery('.pcfme-datepicker-disable-past').length) {
		 jQuery('.pcfme-datepicker-disable-past').datetimepicker({
           format:'d/m/Y',
		   minDate: dateToday,
		   timepicker:false
       });
	   }



	   if (jQuery('.pcfme-daterangepicker').length) {
		  jQuery('.pcfme-daterangepicker').dateRangePicker({
            format: 'DD/MM/YYYY'
            
          });
	   }

	   var dateToday = new Date(); 
	   if (jQuery('.pcfme-daterangepicker-disable-past').length) {
		  jQuery('.pcfme-daterangepicker-disable-past').dateRangePicker({
            format: 'DD/MM/YYYY',
		    startDate: dateToday
		    
          });
	   }



	    if (jQuery('.pcfme-datetimerangepicker').length) {
		  jQuery('.pcfme-datetimerangepicker').dateRangePicker({
                separator : ' - ',
                format: 'DD/MM/YYYY HH:mm',
                time: {
		          enabled: true
	            }
            
          });
	    }

	    var dateToday = new Date(); 
	    if (jQuery('.pcfme-datetimerangepicker-disable-past').length) {

		    jQuery('.pcfme-datetimerangepicker-disable-past').dateRangePicker({
                separator : ' - ',
                format: 'DD/MM/YYYY HH:mm',
		        startDate: dateToday,
		        time: {
		         enabled: true
	            }
		    
            });
	    }
        

        
	   
    });


    $(function() {
        if (jQuery('.pcfme-datetimepicker').length) {
		 jQuery('.pcfme-datetimepicker').datetimepicker({
		 	format:'d/m/Y H:i'
		 });
	    }

	    var dateToday = new Date(); 
	    if (jQuery('.pcfme-datetimepicker-disable-past').length) {
		 jQuery('.pcfme-datetimepicker-disable-past').datetimepicker({
		   minDate: dateToday,
		   format:'d/m/Y H:i'
         });
	    }
	   
	});


	$(function() {
        if (jQuery('.pcfme-timepicker').length) {
		 jQuery('.pcfme-timepicker').datetimepicker({
		 	format:'H:i',
		 	datepicker:false
		 });
	    }
	   
	});


	
   	
    $(function() {
	 
	 if ($('.pcfme-multiselect').length) {
		 $('.pcfme-multiselect').select2({});
	 }
	 
	 if ($('.pcfme-singleselect').length) {
		 $('.pcfme-singleselect').select2({});
	 }
      
    });
	
	
	$(function() {
       $('.pcfme-opener').on('change',function(){
		 var this_obj=$(this);
		 var id= this_obj.attr('id');
         var name= this_obj.attr('name');
		 
		 if (this_obj.hasClass('pcfme-singleselect')){
			
			
			$('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
            $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
			
		 } else if (this_obj.hasClass('pcfme-multiselect')){
			
			
			$('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
            $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
			
		 } else if (this_obj.attr('type')=='checkbox') {
			
			if (this_obj.is(':checked')) {
				$('.open_by_'+id ).closest('.form-row').show();
			} else {
				$('.open_by_'+id ).closest('.form-row').hide();
			}
			
		 } else if ( this_obj.attr('type')=='radio'){
                
                $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();				
                       
          } else if ( this_obj.attr('type')=='text'){
			    $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                 $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
		  
		  } else if ( this_obj.attr('type')=='tel'){
			     
			     $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                 $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
		  } else if ( this_obj.attr('type')=='number'){
			     
			     $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                 $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
		  } else if ( this_obj.attr('type')=='password'){
			     
			     $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                 $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
		  } else if (this_obj.is("textarea")){
			     
			     $('.open_by_'+ id +'_'+this_obj.val() ).closest('.form-row').show();
                        //hide other   
                 $("[class^='open_by_"+ id +"_'],[class*=' open_by_"+ id +"_']").not('.open_by_'+ id +'_'+this_obj.val()).closest('.form-row').hide();
		  }
	    
		
      });
	  
	  $('.pcfme-opener').trigger('change');
	  
	  $('.pcfme-hider').on('change',function(){
		   var this_obj=$(this);
           var id= this_obj.attr('id');
           var name= this_obj.attr('name');
		   
		   if (this_obj.hasClass('pcfme-singleselect')){
                        
                        $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                        $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();
                         
            } else if (this_obj.hasClass('pcfme-multiselect')){
                        
                        $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                        $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();
                         
            } else if (this_obj.attr('type')=='checkbox') {
			
			  if (this_obj.is(':checked')) {
				
				$('.hide_by_'+id ).closest('.form-row').hide();
			  } else {
				    
				$('.hide_by_'+id ).closest('.form-row').show();
			  }
		    
			} else if ( this_obj.attr('type')=='radio'){
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            } else if ( this_obj.attr('type')=='text'){
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            
			} else if ( this_obj.attr('type')=='tel'){
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            }  else if ( this_obj.attr('type')=='number'){
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            }  else if ( this_obj.attr('type')=='password'){
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            }   else if (this_obj.is("textarea")) {
                         
                $('.hide_by_'+ id +'_'+this_obj.val() ).closest('.form-row').hide();
                        //hide other   
                $("[class^='hide_by_"+ id +"_'],[class*=' hide_by_"+ id+"_']").not('.hide_by_'+ id +'_'+this_obj.val()).closest('.form-row').show();       
            }
	  });
	  
	   $('.pcfme-hider').trigger('change');
	});



	  
})(jQuery);



