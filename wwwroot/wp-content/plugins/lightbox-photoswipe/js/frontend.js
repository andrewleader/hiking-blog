jQuery(function($) {
    var selector = '.wp-block-image, .blocks-gallery-item';

    var PhotoSwipe = window.PhotoSwipe,
        PhotoSwipeUI_Default = window.PhotoSwipeUI_Default;

    // create variable that will store real size of viewport
    var realViewportWidth,
        useLargeImages = false,
        firstResize = true,
        imageSrcWillChange;

    $('body').on('click', selector, function(e) {
        if( !PhotoSwipe || !PhotoSwipeUI_Default ) {
            return;
        }

        e.preventDefault();
        openPhotoSwipe( false, this, false, '' );
    });

    $('body').on('click', '.wp-block-andrewleader-betacreator .beta-img-topo', function(e) {
        if( !PhotoSwipe || !PhotoSwipeUI_Default ) {
            return;
        }

        e.preventDefault();
        openPhotoSwipe( false, $(this).closest('.wp-block-andrewleader-betacreator').get(0), false, '' );
    });
    
    var parseThumbnailElements = function(link) {
        var elements = $('body').find(selector + ', .wp-block-andrewleader-betacreator'),
            galleryItems = [],
            index;
        
        elements.each(function(i) {
            var element = $(this);
            var caption = null;

            if (element.hasClass('wp-block-andrewleader-betacreator')) {
                var html = element.get(0).outerHTML;
                // Make the ID unique for the full screen version so the label works
                html = html.replace('show-overlay-', 'pswd-show-overlay');
                galleryItems.push({
                    html: html
                });
            } else {
                var img = element.find('img');

                caption = element.find('figcaption').text();

                if(caption == null && lbwps_options.use_alt == '1') {
                    caption = img.attr('alt');
                }

                galleryItems.push({
                    src: img.attr('src'),
                    w: 0,
                    h: 0,
                    title: caption,
                    getThumbBoundsFn: false,
                    showHideOpacity: true,
                    el: img.get(0)
                });
            }
            if( link === element.get(0) ) {
                index = i;
            }
        });
        
        return [galleryItems, parseInt(index, 10)];
    };

    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1), params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for(var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if(pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function( element_index, element, fromURL, returnToUrl ) {
        var pswpElement = $('.pswp').get(0),
            gallery,
            options,
            items, index;

        items = parseThumbnailElements(element);
        if(element_index == false) {
            index = items[1];
        } else {
            index = element_index;
        }
        items = items[0];

        options = {
            index: index,
            getThumbBoundsFn: false,
            showHideOpacity: true,
            loop: true,
            tapToToggleControls: true,
            clickToCloseNonZoomable: false,
        };
		
		if(lbwps_options.close_on_click == '0') {
			options.closeElClasses = ['pspw__button--close'];
		}

        if(lbwps_options.share_facebook == '1' ||
            lbwps_options.share_twitter == '1' ||
            lbwps_options.share_pinterest == '1' ||
            lbwps_options.share_download == '1') {
            options.shareEl = true;
            options.shareButtons = [];
            if(lbwps_options.share_facebook == '1') {
                if(lbwps_options.share_direct == '1') {
                    url = 'https://www.facebook.com/sharer/sharer.php?u={{image_url}}';
                } else {
                    url = 'https://www.facebook.com/sharer/sharer.php?u={{url}}';
                }
                options.shareButtons.push( {id:'facebook', label:lbwps_options.label_facebook, url:url} );
            }
            if(lbwps_options.share_twitter == '1') {
                if(lbwps_options.share_direct == '1') {
                    url = 'https://twitter.com/intent/tweet?text={{text}}&url={{image_url}}';
                } else {
                    url = 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}';
                }
                options.shareButtons.push( {id:'twitter', label:lbwps_options.label_twitter, url:url} );
            }
            if(lbwps_options.share_pinterest == '1') options.shareButtons.push( {id:'pinterest', label:lbwps_options.label_pinterest, url:'http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}'} );
            if(lbwps_options.share_download == '1') options.shareButtons.push( {id:'download', label:lbwps_options.label_download, url:'{{raw_image_url}}', download:true} );
        } else {
            options.shareEl = false;
        }

        if(lbwps_options.close_on_scroll == '1') options.closeOnScroll = false;
        if(lbwps_options.close_on_drag == '1') options.closeOnVerticalDrag = false;
        if(lbwps_options.history == '1') options.history = true;else options.history = false;
        if(lbwps_options.show_counter == '1') options.counterEl = true;else options.counterEl = false;
        if(lbwps_options.show_fullscreen == '1') options.fullscreenEl = true;else options.fullscreenEl = false;
        if(lbwps_options.show_zoom == '1') options.zoomEl = true;else options.zoomEl = false;
        if(lbwps_options.show_caption == '1') options.captionEl = true;else options.captionEl = false;
        if(lbwps_options.loop == '1') options.loop = true;else options.loop = false;
        if(lbwps_options.pinchtoclose == '1') options.pinchToClose = true;else options.pinchToClose = false;
        if(lbwps_options.taptotoggle == '1') options.tapToToggleControls = true; else options.tapToToggleControls = false;
        options.spacing = lbwps_options.spacing/100;

        if(fromURL == true) {
            options.index = parseInt(index, 10) - 1;
        }

        if(lbwps_options.fulldesktop == '1') {
            options.barsSize = {top: 0, bottom: 0};
        }

        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.listen('gettingData', function (index, item) {

            if (item.html) {
                return;
            }

            // If we need to initialze the image
            if (item.w < 1 || item.h < 1) {

                // Try initializing from url
                var matchResult = item.src.match(/(https:\/\/andrewbares\.blob\.core\.windows\.net\/.*)-(\d+)x(\d+)(\..*)/);
                if (matchResult) {
                    // Input: https://andrewbares.blob.core.windows.net/hiking-blog-images/2019/08/IMG_7696-1024x683.jpg
                    // Group 1: https://andrewbares.blob.core.windows.net/hiking-blog-images/2019/08/IMG_7696
                    // Group 2: 1024 (width)
                    // Group 3: 683 (height)
                    // Group 4: .jpg
                    item.w = parseInt(matchResult[2]);
                    item.h = parseInt(matchResult[3]);

                    // Get the original resolution image
                    item.originalSrc = matchResult[1] + matchResult[4];
                    item.smallerSrc = item.src;
                }
            }

            if (item.originalSrc) {
                if (useLargeImages && navigator.onLine) {
                    item.src = item.originalSrc;
                    item.msrc = item.smallerSrc; // Smaller preview displayed while loading
                } else {
                    item.src = item.smallerSrc;
                }
            }

            // If we still couldn't initialize from url
            if (item.w < 1 || item.h < 1) {
                var img = new Image();
                img.onload = function () {
                    item.w = this.width;
                    item.h = this.height;
                    gallery.updateSize(true);
                };
                img.src = item.src;
            }
        });

        // beforeResize event fires each time size of gallery viewport updates
        // https://photoswipe.com/documentation/responsive-images.html
        gallery.listen('beforeResize', function() {
            // gallery.viewportSize.x - width of PhotoSwipe viewport
            // gallery.viewportSize.y - height of PhotoSwipe viewport
            // window.devicePixelRatio - ratio between physical pixels and device independent pixels (Number)
            //                          1 (regular display), 2 (@2x, retina) ...


            // calculate real pixels when size changes
            realViewportWidth = gallery.viewportSize.x * window.devicePixelRatio;

            // Code below is needed if you want image to switch dynamically on window.resize

            // Find out if current images need to be changed
            if(useLargeImages && realViewportWidth < 1000) {
                useLargeImages = false;
                imageSrcWillChange = true;
            } else if(!useLargeImages && realViewportWidth >= 1000) {
                useLargeImages = true;
                imageSrcWillChange = true;
            }

            // Invalidate items only when source is changed and when it's not the first update
            if(imageSrcWillChange && !firstResize) {
                // invalidateCurrItems sets a flag on slides that are in DOM,
                // which will force update of content (image) on window.resize.
                gallery.invalidateCurrItems();
            }

            if(firstResize) {
                firstResize = false;
            }

            imageSrcWillChange = false;

        });
        
        if (returnToUrl != '') {
            gallery.listen('unbindEvents', function() {
                document.location.href = returnToUrl;
            });
        }
        
        gallery.init();
    };

    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        if (typeof(hashData.returnurl) !== 'undefined') {
            openPhotoSwipe( hashData.pid, null, true, hashData.returnurl );
        } else {
            openPhotoSwipe( hashData.pid, null, true, '' );
        }
    }
});
