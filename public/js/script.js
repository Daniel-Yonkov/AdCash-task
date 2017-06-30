 $(document).ready(function() {
    let button;
      $('#new-product').click(function($products, $clone){
        let products = $('.products:last');
        let clone=products.clone();
        $('option',clone).filter(function(){
          return products.find('option:selected[value="'+$(this).val()+'"]').val();
        }).remove();
        if($('option',clone).length ==1){
          clone.insertBefore("#new-product");
          button=$('#new-product').detach();
        }
        clone.insertBefore("#new-product");
      });
      $('.col-md-12').on('click', '.fa.fa-window-close', function(event){
        if($('.products').length>1){
          $(event.target).closest('.products.col-md-6').remove();
        }
        if(button){
          button.insertBefore('.btn.btn-success.col-md-3');
          button = null;
        }
      });
});