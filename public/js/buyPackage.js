
    $(document).ready(function(){
        $('input[name=packtype]').on('change', function(){
            var n = $(this).val();
            switch(n)
            {
                case 'normal':
                    $('#normal').css('display' , 'block');
                    $('#static').css('display' , 'none');
                    break;
                case 'static':
                    $('#normal').css('display' , 'none');
                    $('#static').css('display' , 'block');
                    break;
            }
        });
    });