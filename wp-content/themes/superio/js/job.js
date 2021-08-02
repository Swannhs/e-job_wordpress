(function($) {
    "use strict";
    
    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        job_init: function() {
            var self = this;

            self.select2Init();

            self.listingDetail();

            self.filterListingFnc();

            self.listingBtnFilter();

            self.portfolio();

            self.sendPrivateMessage();

            self.changePaddingTopContent();

            $(window).resize(function(){
                setTimeout(function(){
                    self.changePaddingTopContent();
                }, 50);
            });

            self.userLoginRegister();
            
            self.dashboardChart();
            
            if ( $('.jobs-listing-wrapper.main-items-wrapper, .employers-listing-wrapper.main-items-wrapper, .candidates-listing-wrapper.main-items-wrapper').length ) {
                $(document).on('change', 'form.filter-listing-form-wrapper input, form.filter-listing-form-wrapper select', function (e) {
                    var form = $(this).closest('form.filter-listing-form-wrapper');
                    if ( $(this).attr('name') == 'filter-salary-type' ) {
                        form.find('input[name=filter-salary-from]').val('');
                        form.find('input[name=filter-salary-to]').val('');
                    }
                    setTimeout(function(){
                        form.trigger('submit');
                    }, 200);
                });

                $(document).on('submit', 'form.filter-listing-form-wrapper', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('action');

                    var formData = $(this).find(":input").filter(function(index, element) {
                            return $(element).val() != '';
                        }).serialize();

                    if( url.indexOf('?') != -1 ) {
                        url = url + '&' + formData;
                    } else{
                        url = url + '?' + formData;
                    }
                    self.jobsGetPage( url );
                    return false;
                });
            }
            // Sort Action
            $(document).on('change', 'form.jobs-ordering select.orderby', function(e) {
                e.preventDefault();
                $('form.jobs-ordering').trigger('submit');
            });
            
            $(document).on('submit', 'form.jobs-ordering', function (e) {
                var url = $(this).attr('action');

                var formData = $(this).find(":input").filter(function(index, element) {
                            return $(element).val() != '';
                        }).serialize();
                
                if( url.indexOf('?') != -1 ) {
                    url = url + '&' + formData;
                } else{
                    url = url + '?' + formData;
                }
                self.jobsGetPage( url );
                return false;
            });
            // ajax pagination
            if ( $('.ajax-pagination').length ) {
                self.ajaxPaginationLoad();
            }

            $(document).on('click', '.advance-search-btn', function(e) {
                e.preventDefault();
                $(this).closest('.filter-listing-form').find('.advance-search-wrapper').slideToggle('fast', 'swing');
            });
            


            // message notification
            $('.message-notification').on('click', function (e) {
                e.stopPropagation();
                $('.notifications-wrapper').toggleClass('active');           
            });

            $('body').on('click', function() {
                if ($('.notifications-wrapper').hasClass('active')) {
                    $('.notifications-wrapper').removeClass('active');
                }
            });
            $('.notifications-wrapper').on('click', function(e) {
                e.stopPropagation();
            });
        },
        dashboardChart: function(){
            var self = this;
            
            // candidate chart
            if ( $('#dashboard_chart_wrapper').length ) {
                var $this = $('#dashboard_chart_wrapper');

                var labels = $this.data('labels');
                var values = $this.data('values');
                var label = $this.data('label');
                var chart_type = $this.data('chart_type');
                var bg_color = $this.data('bg_color');
                var border_color = $this.data('border_color');

                var ctx = $this.get(0).getContext("2d");
                var data = {
                    labels: labels,
                    datasets: [
                        {
                            label: label,
                            backgroundColor: bg_color,
                            borderColor: border_color,
                            borderWidth: 1,
                            data: values
                        },
                    ]
                };

                var options = {
                    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                    scaleBeginAtZero : true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines : false,
                    //String - Colour of the grid lines
                    scaleGridLineColor : "rgba(0,0,0,.05)",
                    //Number - Width of the grid lines
                    scaleGridLineWidth : 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - If there is a stroke on each bar
                    barShowStroke : false,
                    //Number - Pixel width of the bar stroke
                    barStrokeWidth : 2,
                    //Number - Spacing between each of the X value sets
                    barValueSpacing : 5,
                    //Number - Spacing between data sets within X values
                    barDatasetSpacing : 1,
                    legend: { display: false },

                    tooltips: {
                        enabled: true,
                        mode: 'x-axis',
                        cornerRadius: 4
                    },
                }

                var myBarChart = new Chart(ctx, {
                    type: chart_type,
                    data: data,
                    options: options
                });
            }
            


            // employer chart
            var self = this;
            var $this = $('#dashboard_job_chart_wrapper');
            if( $this.length <= 0 ) {
                return;
            }

            // select2
            if ( $.isFunction( $.fn.select2 ) && typeof wp_job_board_pro_select2_opts !== 'undefined' ) {
                var select2_args = wp_job_board_pro_select2_opts;
                select2_args['allowClear']              = false;
                select2_args['minimumResultsForSearch'] = 10;
                
                if ( typeof wp_job_board_pro_select2_opts.language_result !== 'undefined' ) {
                    select2_args['language'] = {
                        noResults: function(){
                            return wp_job_board_pro_select2_opts.language_result;
                        }
                    };
                }
                
                select2_args['width'] = '100%';

                $('.stats-graph-search-form select').select2( select2_args );
            }


            var job_id = $this.data('job_id');
            var nb_days = $this.data('nb_days');
            self.dashboardChartAjaxInit($this, job_id, nb_days);

            $('form.stats-graph-search-form select[name="job_id"]').on('change', function(){
                $('form.stats-graph-search-form').trigger('submit');
            });

            $('form.stats-graph-search-form select[name="nb_days"]').on('change', function(){
                $('form.stats-graph-search-form').trigger('submit');
            });

            $('form.stats-graph-search-form').on('submit', function(e){
                e.preventDefault();
                var job_id = $('form.stats-graph-search-form select[name="job_id"]').val();
                var nb_days = $('form.stats-graph-search-form select[name="nb_days"]').val();
                self.dashboardChartAjaxInit($this, job_id, nb_days);
                return false;
            });
        },
        dashboardChartAjaxInit: function($this, job_id, nb_days) {
            var self = this;
            if( $this.length <= 0 ) {
                return;
            }
            if ( $this.hasClass('loading') ) {
                return;
            }
            $this.addClass('loading');

            var ajaxurl = superio_job_opts.ajaxurl;
            if ( typeof wp_job_board_pro_opts.ajaxurl_endpoint !== 'undefined' ) {
                ajaxurl =  wp_job_board_pro_opts.ajaxurl_endpoint.toString().replace( '%%endpoint%%', 'superio_get_job_chart' );
            }

            $.ajax({
                url: ajaxurl,
                type:'POST',
                dataType: 'json',
                data: {
                    action: 'superio_get_job_chart',
                    job_id: job_id,
                    nb_days: nb_days,
                    nonce: $this.data('nonce'),
                }
            }).done(function(response) {
                if (response.status == 'error') {
                    $this.remove();
                } else {
                    var ctx = $this.get(0).getContext("2d");

                    var data = {
                        labels: response.stats_labels,
                        datasets: [
                            {
                                label: response.stats_view,
                                backgroundColor: response.bg_color,
                                borderColor: response.border_color,
                                borderWidth: 1,
                                data: response.stats_values
                            },
                        ]
                    };

                    var options = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero : true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines : false,
                        //String - Colour of the grid lines
                        scaleGridLineColor : "rgba(0,0,0,.05)",
                        //Number - Width of the grid lines
                        scaleGridLineWidth : 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke : false,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth : 2,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing : 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing : 1,
                        legend: { display: false },

                        tooltips: {
                            enabled: true,
                            mode: 'x-axis',
                            cornerRadius: 4
                        },
                    }

                    if (typeof self.myBarChart !== 'undefined') {
                        self.myBarChart.destroy();
                    }

                    self.myBarChart = new Chart(ctx, {
                        type: response.chart_type,
                        data: data,
                        options: options
                    });
                }
                $this.removeClass('loading');
            });
        },
        portfolio: function() {
            $('.portfolio').each(function(){
                var $this = $(this);
                $('.view-more-gallery', $this).on('click', function(e){
                    $('.item', $this).removeClass('hidden');
                    $('.popup-image-gallery').removeClass('view-more-image');
                    $(this).addClass('hidden');
                    $(document).trigger('resize');
                });
            });
        },
        sendPrivateMessage: function() {
            var self = this;
            $('.send-private-message-btn').magnificPopup({
                mainClass: 'apus-mfp-zoom-in login-popup',
                type:'inline',
                midClick: true
            });
        },
        select2Init: function() {
            // select2
            if ( $.isFunction( $.fn.select2 ) && typeof wp_job_board_pro_select2_opts !== 'undefined' ) {
                var select2_args = wp_job_board_pro_select2_opts;
                select2_args['allowClear']              = true;
                select2_args['minimumResultsForSearch'] = 10;
                
                $( 'select[name=filter-location]' ).select2( select2_args );
                $( 'select[name=filter-type]' ).select2( select2_args );
                $( 'select[name=filter-category]' ).select2( select2_args );
                $('.filter-listing-form select').select2( select2_args );
                
                select2_args['allowClear'] = false;

                $( 'select[name=jobs_ppp]' ).select2( select2_args );
                $( 'select[name=candidates_ppp]' ).select2( select2_args );
                $( 'select[name=employers_ppp]' ).select2( select2_args );

                // filter
                
                $('select[name=email_frequency]').select2( select2_args );
            }
        },

        changePaddingTopContent: function() {
            var admin_bar_h = 0;
            if ( $('#wpadminbar').length ){
                var admin_bar_h = $('#wpadminbar').outerHeight();
            }
            if ($(window).width() >= 1200) {
                var header_h = $('#apus-header').outerHeight();
                
                var header_top_h = header_h;
                var header_main_content_h = header_h - admin_bar_h;
                $('body.page-template-page-dashboard #apus-main-content').css({ 'padding-top': header_h });
                if ( $('.layout-type-fullwidth .filter-sidebar').length ) {
                    $('.layout-type-fullwidth .filter-sidebar').css({ 'top': header_h, 'height': 'calc( 100vh - ' + header_h + 'px )' });
                    $('#apus-main-content').css({ 'padding-top': header_main_content_h });
                }
            } else {
                var header_h = $('#apus-header-mobile').outerHeight();

                if ( $('#jobs-google-maps').is('.fix-map') ) {
                    var header_top_h = header_h + admin_bar_h;
                    var header_main_content_h = header_h - admin_bar_h;
                } else if ( $('.layout-type-fullwidth .filter-sidebar').length ) {
                    if ($(window).width() >= 992) {
                        var header_top_h = header_h + admin_bar_h;
                    } else {
                        var header_top_h = header_h - admin_bar_h;
                    }
                    $('.layout-type-fullwidth .filter-sidebar').css({ 'padding-top': header_top_h, 'height': 'calc( 100vh - ' + header_top_h + 'px )' });
                    $('#apus-main-content').css({ 'padding-top': header_top_h });
                }
                
                $('body.page-template-page-dashboard #apus-main-content').css({ 'padding-top': header_h });
            }
            if ($('#jobs-google-maps').is('.fix-map')) {
                $('#jobs-google-maps').css({ 'top': header_top_h, 'height': 'calc(100vh - ' + header_top_h+ 'px)' });
                $('#apus-main-content').css({ 'padding-top': header_main_content_h });
            }

            $('.offcanvas-filter-sidebar .filter-scroll, .layout-type-fullwidth .filter-sidebar').perfectScrollbar();
        },
        listingDetail: function() {
            var self = this;
            
            $(document).on('click', '.add-a-review', function(e) {
                e.preventDefault();
                var $id = $(this).attr('href');
                if ( $($id).length > 0 ) {
                    $('html,body').animate({
                      scrollTop: $($id).offset().top - 100
                    }, 1000);
                }
            });
        },
        listingBtnFilter: function(){
            $('.btn-view-map').on('click', function(e){
                e.preventDefault();
                $('#jobs-google-maps').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.content-listing .jobs-listing-wrapper').addClass('hidden-sm').addClass('hidden-xs');
                $('.content-listing .candidates-listing-wrapper').addClass('hidden-sm').addClass('hidden-xs');
                $('.content-listing').addClass('no-padding');
                $('.btn-view-listing').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.jobs-pagination-wrapper').addClass('p-fix-pagination');
                $('.candidates-pagination-wrapper').addClass('p-fix-pagination');
                setTimeout(function() {
                    $(window).trigger('pxg:refreshmap');
                });
            });
            $('.btn-view-listing').on('click', function(e){
                e.preventDefault();
                $('#jobs-google-maps').addClass('hidden-sm').addClass('hidden-xs');
                $('.content-listing .jobs-listing-wrapper').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.content-listing .candidates-listing-wrapper').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.content-listing').removeClass('no-padding');
                $('.btn-view-map').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.jobs-pagination-wrapper').removeClass('p-fix-pagination');
                $('.candidates-pagination-wrapper').removeClass('p-fix-pagination');
            });

            $('.show-filter-jobs, .filter-in-sidebar').on('click', function(e){
                e.stopPropagation();
                $('.offcanvas-filter-sidebar').toggleClass('active');
                $('.offcanvas-filter-sidebar + .over-dark').toggleClass('active');
            });
            $(document).on('click', '.offcanvas-filter-sidebar + .over-dark', function(){
                $('.offcanvas-filter-sidebar').removeClass('active');
                $('.offcanvas-filter-sidebar + .over-dark').removeClass('active');
            });
        },

        userLoginRegister: function(){
            var self = this;
            // login/register
            $('.user-login-form, .must-log-in').on('click', function(e){
                e.preventDefault();
                if ( $('.apus-user-login').length ) {
                    $('.apus-user-login').trigger('click');
                }
            });
            $('.apus-user-login, .apus-user-register').magnificPopup({
                mainClass: 'apus-mfp-zoom-in login-popup',
                type:'inline',
                midClick: true,
                modal: true,
                callbacks: {
                    open: function() {
                        self.layzyLoadImage();
                    }
                }
            });
            $('.meesage-meeting-wrapper').perfectScrollbar();
        },

        filterListingFnc: function(){
            $('body').on('click', '.btn-show-filter, .offcanvas-filter-sidebar + .over-dark', function(){
                $('.offcanvas-filter-sidebar, .offcanvas-filter-sidebar + .over-dark').toggleClass('active');
                $('.offcanvas-filter-sidebar').perfectScrollbar();
            });
            
            $('body').on('click', '.tax-radios-field .form-group-inner ul span.caret-wrapper, .tax-checklist-field .form-group-inner ul span.caret-wrapper', function(){
                var con = $(this).closest('.list-item');
                con.find('> ul').slideToggle();
            });


            $('form .toggle-field.hide-content .heading-label i').removeClass('fa-angle-down').addClass('fa-angle-up');
            $('body').on('click', 'form .toggle-field .heading-label', function(){
                if ( $(this).find('i').hasClass('fa-angle-down') ) {
                    $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
                } else {
                    $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
                }
                var parent_e = $(this).closest('.form-group');
                setTimeout(function(){
                    
                    if ( parent_e.hasClass('tax-viewmore-field') ) {
                        var height = parent_e.find('.terms-list').outerHeight();
                        if ( height > 230 ) {
                            parent_e.addClass('show-more');
                        }
                    }
                }, 300);
            });

            $('.tax-viewmore-field').each(function(){
                var height = $(this).find('.terms-list').outerHeight();
                if ( height > 230 ) {
                    $(this).addClass('show-more');
                }
            });

            $(document).on('click', '.toggle-filter-viewmore', function() {
                var $this = $(this);
                var container = $(this).closest('.tax-viewmore-field');

                if ( container.hasClass('show-more') ) {
                    container.addClass('show-less').removeClass('show-more');
                    $this.find('.text').text(wp_job_board_pro_opts.show_less);
                } else {
                    container.addClass('show-more').removeClass('show-less');
                    $this.find('.text').text(wp_job_board_pro_opts.show_more);
                }

            });
        },
        jobsGetPage: function(pageUrl, isBackButton){
            var self = this;
            if (self.filterAjax) { return false; }

            self.jobsSetCurrentUrl();

            if (pageUrl) {
                // Show 'loader' overlay
                self.jobsShowLoader();
                
                // Make sure the URL has a trailing-slash before query args (301 redirect fix)
                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }

                self.filterAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        load_type: 'full'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "load_type" query-string in pagination links
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - jobsGetPage() - ' + errorThrown);
                        
                        // Hide 'loader' overlay (after scroll animation)
                        self.jobsHideLoader();
                        
                        self.filterAjax = false;
                    },
                    success: function(response) {
                        // Update jobs content
                        self.jobsUpdateContent(response);
                        
                        self.filterAjax = false;
                    }
                });
                
            }
        },
        jobsHideLoader: function(){
            $('body').find('.main-items-wrapper').removeClass('loading');
        },
        jobsShowLoader: function(){
            $('body').find('.main-items-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({apusShop: true}, '', pageUrl);
        },
        jobsSetCurrentUrl: function() {
            var self = this;
            
            // Set current page URL
            self.searchAndTagsResetURL = window.location.href;
        },
        /**
         *  Properties: Update jobs content with AJAX HTML
         */
        jobsUpdateContent: function(ajaxHTML) {
            var self = this,
                $ajaxHTML = $('<div>' + ajaxHTML + '</div>');

            var $jobs = $ajaxHTML.find('.main-items-wrapper'),
                $pagination = $ajaxHTML.find('.main-pagination-wrapper');

            // Replace jobs
            if ($jobs.length) {
                $('.main-items-wrapper').replaceWith($jobs);
            }
            // Replace pagination
            if ($pagination.length) {
                $('.main-pagination-wrapper').replaceWith($pagination);
            }
            // Load images (init Unveil)
            self.layzyLoadImage();
            // pagination
            if ( $('.ajax-pagination').length ) {
                self.infloadScroll = false;
                self.ajaxPaginationLoad();
            }

            if ( $.isFunction( $.fn.select2 ) && typeof wp_job_board_pro_select2_opts !== 'undefined' ) {
                var select2_args = wp_job_board_pro_select2_opts;
                select2_args['allowClear']              = false;
                select2_args['minimumResultsForSearch'] = 10;
                select2_args['width'] = 'auto';
                
                $('select.orderby').select2( select2_args );
                $( 'select[name=jobs_ppp]' ).select2( select2_args );
                $( 'select[name=candidates_ppp]' ).select2( select2_args );
                $( 'select[name=employers_ppp]' ).select2( select2_args );
            }

            self.updateMakerCards();
            setTimeout(function() {
                // Hide 'loader'
                self.jobsHideLoader();
            }, 100);
        },

        /**
         *  Shop: Initialize infinite load
         */
        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('body').find('.ajax-pagination'),                   
                nextPageUrl;

            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    //bufferPx = 0;
                
                /* Bind: Window resize event to re-calculate the 'pxFromMenuToBottom' value (so the items load at the correct scroll-position) */
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        var $infloadControls = $('.ajax-pagination'); // Note: Don't cache, element is dynamic
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
                    // If distance remaining in the scroll (including buffer) is less than the pagination element to bottom:
                    if (pxFromWindowBottomToBottom < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
                /* Bind: "Load" button */
                $productsWrap.on('click', '.main-pagination-wrapper .apus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); // Trigger scroll in case the pagination element (+buffer) is above the window bottom
            }
        },
        /**
         *  Shop: AJAX load next page
         */
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.filterAjax) return false;
            
            // Get elements (these can be replaced with AJAX, don't pre-cache)
            var $nextPageLink = $('.apus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
                // Show 'loader'
                $infloadControls.addClass('apus-loader');
                
                self.setPushState(nextPageUrl);

                self.filterAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'items'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('APUS: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
                        // Hide 'loader'
                        $infloadControls.removeClass('apus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), // Wrap the returned HTML string in a dummy 'div' element we can get the elements
                            $gridItemElement = $('.items-wrapper', $response).html(),
                            $resultCount = $('.results-count .last', $response).html(),
                            $display_mode = $('.main-items-wrapper').data('display_mode');
                        

                        // Append the new elements
                        if ( $display_mode == 'grid' || $display_mode == 'simple') {
                            $('.main-items-wrapper .items-wrapper .row').append($gridItemElement);
                        } else {
                            $('.main-items-wrapper .items-wrapper').append($gridItemElement);
                        }
                        
                        // Append results
                        $('.main-items-wrapper .results-count .last').html($resultCount);

                        // Update Maps
                        self.updateMakerCards(response);

                        // Load images (init Unveil)
                        self.layzyLoadImage();
                        
                        // Get the 'next page' URL
                        nextPageUrl = $response.find('.apus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.main-items-wrapper').addClass('all-jobs-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true;
                            }
                            $infloadControls.find('.apus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.filterAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); // Trigger 'scroll' in case the pagination element (+buffer) is still above the window bottom
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                }
            }
        },
        addCommas: function(str) {
            var parts = (str + "").split("."),
                main = parts[0],
                len = main.length,
                output = "",
                first = main.charAt(0),
                i;
            
            if (first === '-') {
                main = main.slice(1);
                len = main.length;    
            } else {
                first = "";
            }
            i = len - 1;
            while(i >= 0) {
                output = main.charAt(i) + output;
                if ((len - i) % 3 === 0 && i > 0) {
                    output = wp_job_board_pro_opts.money_thousands_separator + output;
                }
                --i;
            }
            // put sign back
            output = first + output;
            // put decimal part back
            if (parts.length > 1) {
                output += wp_job_board_pro_opts.money_dec_point + parts[1];
            }
            return output;
        }
    });

    $.apusThemeExtensions.job = $.apusThemeCore.job_init;

    
})(jQuery);
