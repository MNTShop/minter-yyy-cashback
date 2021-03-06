jQuery( function($){
    // Settings page tabbing

    $('.settings-nav li a').click(function(e){
        e.preventDefault();
        var $$ = $(this);
        $('.settings-nav li a').not($$).closest('li').removeClass('active');
        $$.closest('li').addClass('active');

        var tabClicked = $$.attr('href').split('#')[1];
        var $s = $('#myc-settings-section-' + tabClicked);

        $('#myc-settings-sections .myc-settings-section').not($s).hide();
        $s.show();

        $('#myc-settings-page input[type="submit"]').css({
            'visibility' : tabClicked === 'welcome' ? 'hidden' : 'visible'
        });

        setUserSetting('myc_panels_setting_tab', tabClicked);
    });
    //myc-settings-reward-sections
    $('.settings-nav-rewards li a').click(function(e){
        e.preventDefault();
        var $$ = $(this);
        $('.settings-nav-rewards li a').not($$).closest('li').removeClass('active');
        $$.closest('li').addClass('active');

        var tabClicked = $$.attr('href').split('#')[1];
        var $s = $('#myc-settings-section-' + tabClicked);

        $('#myc-settings-reward-sections .myc-settings-section').not($s).hide();
        $s.show();

        $('#myc-settings-page input[type="submit"]').css({
            'visibility' : tabClicked === 'welcome' ? 'hidden' : 'visible'
        });

        setUserSetting('myc_panels_setting_tab', tabClicked);
    });



    if( window.location.hash ) {
        $('.settings-nav-rewards li a[href="' + window.location.hash + '"]').click();
    }
    if( window.location.hash ) {
        $('.settings-nav li a[href="' + window.location.hash + '"]').click();
    }
    console.log(window.location.hash);

    // Save the tab the user last clicked

    var tabClicked = getUserSetting('myc_panels_setting_tab');
    if(tabClicked === '') { $('.settings-nav li a').first().click(); }
    else {
        if(tabClicked === 'reward_schedule_section'||tabClicked === 'reward_register_section'){
            $('.settings-nav li a[href="#' + 'reward_section' + '"]').first().click();
            $('.settings-nav-rewards li a[href="#' + tabClicked + '"]').first().click();
        }
        $('.settings-nav li a[href="#' + tabClicked + '"]').first().click();}

    // Search settings

    var highlightSetting = function($s){

        // Click on the correct container
        $('.settings-nav li a[href="#' + $s.closest('.myc-settings-section').data('section') + '"]').first().click();
        $('.settings-nav-rewards li a[href="#' + $s.closest('.myc-settings-section').data('section') + '"]').first().click();

        $s.addClass('highlighted');

        $s
            .find('label')
            .css('border-left-width', 0)
            .animate({ 'border-left-width': 5 }, 'normal')
            .delay(4000)
            .animate({ 'border-left-width': 0 }, 'normal', function(){
                $s.removeClass('highlighted');
            });

        $s.find('input,textarea').focus();
    };

    var doSettingsSearch = function(){
        var $$ = $(this),
            $r = $('#myc-settings-search .results'),
            query = $$.val();

        if( query === '' ) {
            $r.empty().hide();
            return false;
        }

        // Search all the settings
        var settings = [];
        $('#myc-settings-sections .myc-setting').each(function(){
            var $s = $(this);
            var isMatch = 0;

            var indexes = {
                'title' : $s.find('label').html().toLowerCase().indexOf( query ),
                'keywords' : $s.find('.description').data('keywords').toLowerCase().indexOf( query ),
                'description' : $s.find('.description').html().toLowerCase().indexOf( query )
            };

            if( indexes.title === 0 ) isMatch += 10;
            else if( indexes.title !== -1 ) isMatch += 7;

            if( indexes.keywords === 0 ) isMatch += 4;
            else if( indexes.keywords !== -1 ) isMatch += 3;

            if( indexes.description === 0 ) isMatch += 2;
            else if( indexes.description !== -1 ) isMatch += 1;


            if( isMatch > 0 ) {
                settings.push($s);
                $s.data('isMatch', isMatch);
            }
        });

        $r.empty();

        if( settings.length > 0 ) {
            $r.show();
            settings.sort( function(a,b){
                return b.data('isMatch') - a.data('isMatch');
            } );

            settings = settings.slice(0, 8);

            $.each(settings, function(i, el){
                $('#myc-settings-search .results').append(
                    $('<li></li>')
                        .html( el.find('label').html() )
                        .click(function(){
                            highlightSetting( el );
                            $r.fadeOut('fast');
                            $('#myc-settings-search input').blur();
                        })
                );
            });
        }
        else {
            $r.hide();
        }
    };

    $('#myc-settings-search input')
        .keyup(doSettingsSearch)
        .click(doSettingsSearch)
        .blur( function(){
            $('#myc-settings-search .results').fadeOut('fast');
        } );

    //set datePicker

        $('.jquery-datepicker').datetimepicker();

} );
