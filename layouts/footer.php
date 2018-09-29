<br><br><div id="footer">
      <div class="container">
        <p class="text-muted credit">SMD Radius © 2017. Dibuat oleh <a href="#">Rizal Alfiannor</a></p>
      </div>
    </div>

    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script>

        $('#calendar').datepicker({
        });

        !function ($) {
            $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
                $(this).find('em:first').toggleClass("glyphicon-minus");      
            }); 
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function () {
          if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
          if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })
    </script>   
