var GLOBALS = (function($) {
  'use strict';

  return {
    $win: $(window),
    $doc: $(document)
  };

}(jQuery));

var CRIMESTOPPERS = (function($) {
  'use strict';

  var $win = GLOBALS.$win,
      $doc = GLOBALS.$doc;

  // breakpoint listener
  // listen to breakpoint changes based on content property value (breakpoint name) retrieved from the body's after psuedo element
  var breakPointListener = function() {
    this.afterElement = window.getComputedStyle ? window.getComputedStyle(document.body, ':after') : false;
    this.currentBreakpoint = '';
    this.lastBreakpoint = '';
    this.init();
  };

  breakPointListener.prototype = {

    init: function () {

      var self = this;
            
      if(!self.afterElement) {

        return;

      }

      self.resizeListener();

    },

    resizeListener: function () {

      var self = this;

      $win.on('resize orientationchange load', function() {

        // regex for removing quotes added by browsers
        self.currentBreakpoint = self.afterElement.getPropertyValue('content').replace(/^["']|["']$/g, '');
                
        if (self.currentBreakpoint !== self.lastBreakpoint) {

          $win.trigger('breakpointChange', self.currentBreakpoint);
          self.lastBreakpoint = self.currentBreakpoint;

        }

      });

    }

  };

  parent.breakPointListener = parent.breakPointListener || new breakPointListener();

  // breakpoint image replacement
  $.fn.bpImgReplace = function() {

    var pluginName = 'bpImgReplace';

    function Plugin(el) {

      this.el = $(el),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        this.getImage();

      },

      getImage: function() {

        var self = this,
            imgSm = this.el.attr('data-img-sm'),
            imgLg = this.el.attr('data-img-lg');

        // set new image based on breakpoint
        self.setImage(imgSm, imgLg);

      },

      setImage: function(imgSm, imgLg) {

        var self = this;

        // breakpoint listener
        $(window).on('breakpointChange', function(e, breakpoint) {

          if(breakpoint === 'bp-sm') {

            self.el.attr('src', imgSm);

          } else {

            self.el.attr('src', imgLg);

          }

        });

        // IE fallback
        if ($('html').hasClass('ie7') || $('html').hasClass('ie8')) {

          // set image to large
          self.el.attr('src', imgLg);

        }

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this));

    });

  };

  // navigation
  $.fn.navigation = function(opts) {

    var pluginName = 'navigation',
        defaults = {
          navClass: 'nav',
          navOpenEl: '#open-nav',
          navCloseEl: '#close-nav'
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el),
      this.body = $('body'),
      this.navItem = this.el.find('li'),
      this.navLink = this.navItem.find('a'),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        self.setup();

        // enable nav toggling
        self.navToggling();

        // breakpoint check
        self.breakpointCheck();

      },

      setup: function() {

        // define open el
        this.openEl = $(settings.navOpenEl);

        // define close el
        this.closeEl = $(settings.navCloseEl);

      },

      toggledState: function() {

        var self = this;

        self.el.addClass(settings.navClass + '--active');
        self.body.addClass(settings.navClass + '-is-open');

      },

      untoggledState: function() {

        var self = this;

        self.el.removeClass(settings.navClass + '--active');
        self.body.removeClass(settings.navClass + '-is-open');

      },

      navToggling: function() {

        var self = this;

        this.openEl.on('click', function() {

          self.toggledState();

        });

        this.closeEl.on('click', function() {

          self.untoggledState();

        });

      },

      breakpointCheck: function() {

        var self = this;

        $(window).on('breakpointChange', function(e, breakpoint) {

          if((breakpoint === 'bp-md') || (breakpoint === 'bp-lg')) {

            self.untoggledState();

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // scrollTo
  $.fn.scrollTo = function(opts) {

    var pluginName = 'scrollTo',
        defaults = {
          addedOffset: 0,
          speed: 500,
          onComplete: null
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this,
            animationComplete = false;

        $('html, body').animate({
          scrollTop: self.el.offset().top - settings.addedOffset
        }, settings.speed, function(){

          if (!animationComplete && settings.onComplete) {

            settings.onComplete.call(self);

            animationComplete = true;

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // togglable content
  $.fn.togglableContent = function(opts) {

    var pluginName = 'togglableContent',
        defaults = {
          toggleClass: '.toggle'
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el),
      this.elClass = this.el.attr('class').split(' ')[0];
      this.toggle = this.el.find(settings.toggleClass),
      this.toggleClass = this.toggle.attr('class'),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        // enable toggling
        this.toggling();

      },

      toggling: function() {

        var self = this;

        self.toggle.on('click', function() {

          if (!self.el.hasClass(self.elClass + '--active')) {

            self.el.addClass(self.elClass + '--active');
            self.toggle.addClass(self.toggleClass + '--active');

          } else {

            self.el.removeClass(self.elClass + '--active');
            self.toggle.removeClass(self.toggleClass + '--active');

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // equal heights
  $.fn.equalHeights = function(opts) {

    var pluginName = 'equalHeights',
        defaults = {
          className: null,
          extraSpace: null
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el).find(settings.className),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // compare heights
        self.compareHeights();

        // run on win resize
        $win.on('resize', function() {

          self.compareHeights();

        });
        

      },

      compareHeights: function() {

        var self = this,
            tallest = 0;

        self.el.css('min-height', 0);

        self.el.each(function() {

          var thisHeight = $(this).outerHeight();

          if (thisHeight >= tallest) {
            tallest = thisHeight;
          }

        });

        self.el.css('min-height', tallest + settings.extraSpace);

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // tip modal
  $.fn.tipModal = function(opts) {

    var pluginName = 'tipModal',
        defaults = {
          modalClass: 'tip-modal',
          delay: 500, // delays opening of modal
          afterOpen: null, // callback for opening of modal
          afterClose: null // callback for closing of modal
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.modal,
      this.modalWindow;

      this.tipID,
      this.tipCards = $('#tip-cards-holder');

      this.el = $(el),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // define trigger
        this.trigger = this.el;

        // define overlay
        this.overlay = $('<div class="' + settings.modalClass + '-overlay"></div>');

        // define modal
        this.modal = $('<div id="' + settings.modalClass + '" class="' + settings.modalClass + '"><div class="' + settings.modalClass + '__window"><button class="' + settings.modalClass + '__close ' + settings.modalClass + '__close-btn" type="button">Close</button></div></div>')

        // define modal window
        this.modalWindow = this.modal.find('.' + settings.modalClass + '__window');

        // open modal on click of trigger
        this.trigger.on('click', function() {

          self.openModal();

          return false;

        });

      },

      tipIDCheck: function() {

        var self = this;

        // check to see if trigger has tip ID
        if (self.trigger.attr('data-tip-id')) {

          // grab tip ID value and store it
          self.tipID = self.trigger.attr('data-tip-id');

          // pass tip ID to modal
          self.modal.attr('data-tip-id', self.tipID);

          // create hidden input field el with reference tip ID value
          this.hiddenInput = $('<input type="hidden" name="tipRefID" id="tipRefID" value="' + self.tipID + '"/>');
          self.modal.find('.tip-cards').append(this.hiddenInput);

        }

      },

      appendTipCards: function() {

        var self = this;

        // clone tip cards
        var tipCards = self.tipCards.clone();

        // check for existing tip cards, remove previous instance
        self.modalWindow.find('.tip-cards').remove();

        // append to modal window, remove hidden class, set aria value
        tipCards.appendTo(self.modalWindow)
          .attr({
            'id': 'tip-cards',
            'aria-hidden': false
          })
          .removeClass('tip-cards--hidden');

        // tip ID check
        self.tipIDCheck();

        // initialize tip cards
        tipCards.tipCards();

        // add delay to allow transition
        setTimeout(function() {

          tipCards.addClass('tip-cards--active');

        }, settings.delay);

        // detatch tip cards holder from DOM
        // IMPORTANT: This is required to preserve the uniquness of any ID in the tip cards so we don't have 2 of the same ID on the page
        self.tipCards.detach();

      },

      openModal: function() {

        var self = this;

        // append overlay to body
        self.overlay.appendTo('body');

        // add delay for overlay transition
        setTimeout(function() {

          // add engaged class to body
          $('body').addClass(settings.modalClass + '-engaged');

        }, 1);

        // append modal to body
        self.modal.appendTo('body');

        // add visible class to modal, set aria attributes
        self.modal.addClass(settings.modalClass + '--visible')
          .attr({
            'role': 'dialog',
            'aria-hidden': false,
            'aria-modal': true,
            'tabindex': -1
          });

        // append tip cards to modal window
        self.appendTipCards();

        // set aria hidden to true for all elements except modal
        $('body > *').not(self.modal).attr('aria-hidden', true);

        // set aria hidden to false for overlay
        self.overlay.attr('aria-hidden', false);

        // add delay to allow setting focus to close button
        setTimeout(function() {

          self.el.find(settings.modalClass + '__close-btn').focus();

        }, 500);

        // bind key pressing
        $doc.bind('keyup', this.keyPressing());

        // enable closing of modal
        self.modal.find('.' + settings.modalClass + '__close').on('click', function() {

          self.closeModal();

        });

        // callback for when modal is opened
        if (settings.afterOpen) {

          settings.afterOpen.call(self);

        }

      },

      closeModal: function() {

        var self = this;

        // remove visible class from modal
        self.modal.removeClass(settings.modalClass + '--visible')

        // remove engaged class from body
        $('body').removeClass(settings.modalClass + '-engaged');

        // add delay for overlay transition
        setTimeout(function() {

          // remove overlay
          self.overlay.remove();

          // remove modal
          self.modal.remove();

        }, 300);

        // set aria hidden to false
        $('body > *').attr('aria-hidden', false);

        // unbind key pressing
        $doc.unbind('keyup', self.keyPressing());

        // callback for when modal is closed
        if (settings.afterClose) {

          settings.afterClose.call(self);

        }

      },

      keyPressing: function() {

        var self = this;

        $doc.keyup(function(e) {

          // ESC key closing
          if (e.keyCode == 27) {

            self.closeModal();

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this));

    });


  };

  // tip cards
  $.fn.tipCards = function(opts) {

    var pluginName = 'tipCards',
        defaults = {
          cardEl: '.tip-card', // card element
          cardsContainerEl: '.tip-cards', // cards container element
          cardsTrackEl: '.tip-cards__track', // cards track element
          cardWidth: 600, // width of each card
          cardMargin: 60, // spacing between cards
          position: 0, // starting position
          speed: 500 // animation speed
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.animating = false,
      this.winWidth = $(window).width(),
      this.position = settings.position,
      this.current = this.position,
      this.isValid = true,
      this.cardCount,
      this.cardWidth,
      this.cardMargin = settings.cardMargin,
      this.trackWidth,
      this.trackPos,
      this.progressEl,
      this.skipToEndButton;

      this.el = $(el),
      this.card = this.el.find(settings.cardEl),
      this.cardClass = settings.cardEl.replace(/\./g, ''),
      this.cardContainerClass = settings.cardsContainerEl.replace(/\./g, ''),
      this.cardsTrack = this.el.find(settings.cardsTrackEl),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // setup
        self.setup();

        // card toggling
        self.cardToggling();

        // resize detection
        self.resize();

        // breakpoint change detection
        self.breakpoint();

        // form submission
        self.formSubmission();

      },

      setup: function() {

        var self = this;

        // add position data attribute and tab index values to each card
        self.card.each(function(i) {

          $(this).attr({
            'data-card-pos': i,
            'tabindex': -1
          });

        });

        // get width of card
        self.cardWidth = self.card.outerWidth();

        // get count of cards
        self.cardCount = self.card.length;

        // set margin to card
        self.setCardMargin();

        // calculate width of track
        self.calculateTrackWidth();

        // set width to track
        self.setTrackWidth();

        // calculate track starting position
        self.calculateTrackPos();

        // set track starting position
        self.setTrackPos();

        // add active class to first card in track
        $(self.card[0]).addClass(self.cardClass + '--active');

        // build progress bar
        self.buildProgressBar();

        // generate random tip number
        self.generateTipNumber();

        // add delay to allow setting focus to first card button
        setTimeout(function() {

          self.el.find('.tip-card--intro .tip-card__button').focus();

        }, 1000);

        // disable initial tabbing through elements (prevents user from tabbing through cards that are non-active)
        // only on non-Touch devices
        if (!Modernizr.touch) {

          setTimeout(function() {

            self.disableElTabbing('div,span,a,input,select,textarea,button,iframe');

            // re-enable tabbing for elements within active card
            self.enableElTabbing('input,select,textarea,button');

          }, 500);

        }

      },

      buildProgressBar: function() {

        var self = this;

        // define progress el
        self.progressEl = $('<div class="' + self.cardContainerClass + '__progress"><div class="' + self.cardContainerClass + '__progress__container"><div class="' + self.cardContainerClass + '__progress__bar"></div></div></div>');

        // append progress el to cards
        self.el.prepend(self.progressEl);

        // define skip to end button
        self.skipToEndBtn = $('<button class="' + self.cardContainerClass + '__progress__skip' + '" type="button">Skip to end</button>');

        // prepend skip to end button to progress el container
        var progressElContainer = '.' + self.cardContainerClass + '__progress__container';
        $(progressElContainer).prepend(self.skipToEndBtn);

        // define progress bar
        self.progressBar = self.progressEl.find('.' + self.cardContainerClass + '__progress__bar');

        // append percentage layer to progress bar to track cards via animation
        self.progressBar.append('<span class="' + self.cardContainerClass + '__progress__bar__pct-layer"></span>');

        // skip to end button functionality (built as part of progress bar)
        self.skipToEndBtn.on('click', function () {

          // check to see if track is animating
          if (!self.animating) {

            // set animating to true
            self.animating = true;

            // set position to "verify and submit this tip card" (2 off final card)
            self.position = self.card.length - 2;

            // go to card in position
            self.goTo();

          }

        }) 

      },

      setCardMargin: function() {

        var self = this;

        self.card.css({
          'margin-left': (self.cardMargin / 2) + 'px',
          'margin-right': (self.cardMargin / 2) + 'px'
        })

      },

      calculateTrackWidth: function() {

        var self = this;

        self.trackWidth = (self.cardCount * self.cardWidth) + (self.cardMargin * self.cardCount);

      },

      setTrackWidth: function() {

        var self = this;

        self.cardsTrack.css({
          'width': self.trackWidth + 'px'
        })

      },

      calculateTrackPos: function() {

        var self = this;

        self.trackPos = (self.winWidth / 2) - (self.cardWidth / 2) - (self.cardWidth * self.position) - (self.cardMargin / 2) - (self.cardMargin * self.position);

      },

      setTrackPos: function() {

        var self = this;

        self.cardsTrack.css({
          'left': self.trackPos + 'px'
        });

      },

      cardValidation: function() {

        var self = this;

        // check to see if current card has required class
        if ($(self.card[self.current]).hasClass(self.cardClass + '--required')) {

          self.isValid = true;

          // look for required fields
          $(self.card[self.current]).find('.field--required').each(function() {

            var $this = $(this),
                selectInput = $this.find('.select__input'),
                errorMsg = '<div class="field__error-msg">This is a required field</div>';

            // validate required select inputs
            if (selectInput.length) {

              if (selectInput.find('option').not(':first').is(':selected')) {

                if ($this.hasClass('field--error')) {

                  $this.removeClass('field--error');
                  $this.find('.field__error-msg').remove();
                  $this.find('select').attr('aria-invalid', false);

                  self.isValid = true;

                }

              } else {

                $this.removeClass('field--error');
                $this.find('.field__error-msg').remove();

                $this.addClass('field--error');
                $this.find('select').attr('aria-invalid', true).focus();
                $this.append(errorMsg);

                self.isValid = false;

              }

            }

          });

        }

      },

      cardToggling: function() {

        var self = this;

        // next card toggling
        $('[data-card-direction="next"]').on('click touchend', function() {

          // run validation check
          self.cardValidation();

          // if validation passes, continue to next card
          if (self.isValid == true) {

            // check to see if track is animating
            if (!self.animating) {

              // set animating to true
              self.animating = true;

              // show skip to end button after 2nd card
              if (self.position > 0) {

                self.skipToEndBtn.addClass('tip-cards__progress__skip--active');

              }

              // increase position by 1
              self.position++;

              // go to card in position
              self.goTo();

            }

          }

        });

        // previous card toggling
        $('[data-card-direction="previous"]').on('click touchend', function() {

          // valid to true
          self.isValid = true;

          // check to see if track is animating
          if (!self.animating) {

            // set animating to true
            self.animating = true;

            // decrease position by 1
            self.position--;

            // hide skip to end button before 2nd card
            if (self.position == 1) {

              self.skipToEndBtn.removeClass('tip-cards__progress__skip--active');

            }

            // go to card in position
            self.goTo();

          }

        });

      },

      goTo: function() {

        var self = this;

        // remove active class from current card in position
        $(self.card[self.current]).removeClass(self.cardClass + '--active');

        // recalculate track position
        self.calculateTrackPos();

        // animate to track position
        self.cardsTrack.animate({

          left: self.trackPos

        }, settings.speed, function() {

          self.animating = false;

        });

        // add active class to card now in position
        $(self.card[self.position]).addClass(self.cardClass + '--active');

        // set current to position
        self.current = self.position;

        // progress bar percentage layer animation
        var pctLayer = '.' + self.cardContainerClass + '__progress__bar__pct-layer';
        $(pctLayer).css('width', ((self.current / (self.cardCount - 1)) * 100 + '%'));

        // animate to top of modal window if lower than top on card change
        if ( $('.tip-modal__window').scrollTop() > 0 ) {

          $('.tip-modal__window').animate({scrollTop: 0}, 500);

        }

        
        // only on non-Touch devices
        if (!Modernizr.touch) {

          // add delay to allow setting focus to first field element
          setTimeout(function() {

            $(self.card[self.position]).find('.tip-card__fieldset .field:first-child select, .tip-card__fieldset .field:first-child input, .tip-card__fieldset .field:first-child textarea').focus();

          }, 500);

          // check for last card
          if (self.position == (self.cardCount - 2)) {

            // add delay to allow setting focus to submit
            setTimeout(function() {

              $(self.card[self.position]).find('.tip-card__button-container .btn').focus();

            }, 500);

          }

          // check for first card
          if (self.position == 0) {

            // add delay to allow setting focus to btn
            setTimeout(function() {

              $(self.card[self.position]).find('.btn').focus();

            }, 500);

          }

          // disable tabbing for all elements
          self.disableElTabbing('div,span,a,input,select,textarea,button,iframe');

          // re-enable tabbing for elements within active card
          self.enableElTabbing('input,select,textarea,button');

        }

      },


      disableElTabbing: function(els) {

        var self = this;

        self.el.find($(els)).each(function(i) {

          $(this).attr('tabindex', '-1');

        });

      },

      enableElTabbing: function(els) {

        var self = this;

        $(self.card[self.position]).find($(els)).each(function(i) {

          $(this).attr('tabindex', '1');

        });

        var inputEls = $(self.card[self.position]).find(els),
            inputTo;

        inputEls.on('keydown', function(e) {

          // detect tab key
          if (e.keyCode == 9 || e.which == 9) {

            e.preventDefault();

            var nextEl = inputEls.get(inputEls.index(this) + 1),
                prevEl = inputEls.get(inputEls.index(this) - 1);

            // check to see if next el is hidden
            if ($(inputEls.get(inputEls.index(this) + 1)).is(':hidden')) {

              inputTo = inputEls.parent().siblings().find('button').get(inputEls.index(this) + 1);
 
            } else {

              inputTo = inputEls.get(inputEls.index(this) + 1);

            }

            // move focus to inputTo, otherwise focus first input
            if (inputTo) {

              inputTo.focus();

            } else {

              inputEls[0].focus();

            }

          }

        });

      },

      resize: function() {

        var self = this;

        // window resize listener
        $(window).on('resize', function() {

          // get window width
          self.winWidth = $(window).width();

          // recalculate track position
          self.calculateTrackPos();

          // set new track position
          self.setTrackPos();

        });

      },

      breakpoint: function() {

        var self = this;

        // breakpoint change listener
        $(window).on('breakpointChange', function(e, breakpoint) {

          // small breakpoint
          if(breakpoint === 'bp-sm') {

            // redefine card width
            self.cardWidth = 300;

            // redefine card margin
            self.cardMargin = -20;

          } else { // outside of small breakpoint

            // redfine card width
            self.cardWidth = settings.cardWidth;

            // redefine card margin
            self.cardMargin = settings.cardMargin;

          }

          // set new margin to card
          self.setCardMargin();

          // recalculate width of track
          self.calculateTrackWidth();

          // set new width to track
          self.setTrackWidth();

          // recalculate track position
          self.calculateTrackPos();

          // set new track position
          self.setTrackPos();

        });

      },

      generateTipNumber: function() {

        var self = this;

        // generate random 5 digit number
        var num = Math.floor(10000 + Math.random() * 90000);

        // add generated number to hidden input value
        self.el.find('#tip-number-input').val('Tip #' + num);

        // append number to confirmation
        self.el.find('#tip-number').text(num);

      },

      formSubmission: function() {

        var self = this;

        // submit event for form
        self.el.on('submit', function(ev, data) {

          var verifyCard = self.el.find('.tip-card--verify');

          // recaptcha response
          var recaptchaResp = grecaptcha.getResponse(reCaptchaID);

          // recaptcha error
          var errorMsg = $('<div class="tip-card__error-msg"><p>Please verify this tip using the reCAPTCHA field below</p></div>');

          // loader
          var loader = $('<div class="tip-card__loader"><span>Submitting Tip...</span></div>');

          // check recaptcha for valid response
          if(recaptchaResp.length !== 0) {

            // remove error msg
            verifyCard.find('.tip-card__error-msg').remove();

            // append loader
            verifyCard.find('.tip-card__button-container').append(loader);

            // run ajax call
            $.ajax({
              url: self.el.attr('action'),
              type: 'POST',
              data: self.el.serialize(), // put all data fields in a text string
              dataType: 'html',
              success: function(data) {

                // advance to the last card
                self.position++;
                self.goTo();

                // remove loader
                verifyCard.find('.tip-card__loader').remove();

                // remove skip to end button
                self.skipToEndBtn.remove();

              }

            }); 

          } else { // error

            // remove error msg
            verifyCard.find('.tip-card__error-msg').remove();

            // append error msg
            errorMsg.insertBefore(verifyCard.find('.tip-card__recaptcha'));

          }

          // prevent form from submitting
          ev.preventDefault();

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // tip form
  $.fn.tipForm = function(opts) {

    var pluginName = 'tipForm';

    function Plugin(el) {

      this.el = $(el),
      this.isValid = false,
      this.fieldsValid = true,
      this.scrollOffset = 20,
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // hidden controls toggling
        $('[data-hidden-control]').hiddenControl();

        // form submission
        self.formSubmission();

        // breakpoint change listener to calculate scroll offset
        $(window).on('breakpointChange', function(e, breakpoint) {

          if(breakpoint === 'bp-xlg') {

            self.scrollOffset = 125;

          } else {

            self.scrollOffset = 20;

          }

        });

      },

      formSubmission: function() {

        var self = this;

        self.el.on('submit', function() {

          // run validation
          self.validateSelectField();

          // if validation passes, continue to next card
          if (self.fieldsValid == true) {

            // verify block
            var verifyBlock = self.el.find('.tip-form__block--verify');

            // recaptcha response
            var recaptchaResp = grecaptcha.getResponse();

            // recaptcha error
            var errorMsg = $('<div class="tip-form__error-msg"><p>Please verify this tip using the reCAPTCHA field below</p></div>');

            // loader
            var loader = $('<div class="tip-form__loader"><span>Submitting Tip...</span></div>');

            // check recaptcha for valid response
            if(recaptchaResp.length !== 0) {

              // remove error msg
              verifyBlock.find('.tip-form__error-msg').remove();

              // append loader
              verifyBlock.find('.tip-form__block__button-container').append(loader);

              self.isValid = true;

            } else { // error

              // remove error msg
              verifyBlock.find('.tip-form__error-msg').remove();

              // append error msg
              errorMsg.insertBefore(verifyBlock.find('.tip-form__recaptcha'));

              // reload reCAPTCHA
              grecaptcha.reset();

              self.isValid = false;

            }

          }

          return self.isValid;

        });

      },

      validateSelectField: function() {

        var self = this;
 
        self.el.find('.field--required').each(function() {

          var $this = $(this),
              selectInput = $this.find('.select__input'),
              errorMsg = '<div class="field__error-msg">This is a required field</div>';

          if (selectInput.length) {

            if (selectInput.find('option').not(':first').is(':selected')) {

              if ($this.hasClass('field--error')) {

                $this.removeClass('field--error');
                $this.find('.field__error-msg').remove();
                $this.find('select').attr('aria-invalid', false);

                self.fieldsValid = true;

              }

            } else {

              $this.removeClass('field--error');
              $this.find('.field__error-msg').remove();

              $this.addClass('field--error');
              $this.find('select').attr('aria-invalid', true);
              $this.append(errorMsg);

              self.fieldsValid = false;

              // scroll to error
              $this.scrollTo({
                addedOffset: self.scrollOffset
              });

            }

          }

        });
 
      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this));

    });

  };

  // hidden control toggling
  $.fn.hiddenControl = function(opts) {

    var pluginName = 'hiddenControl',
        defaults = {
          speed: 300
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el),
      this.showControl = this.el.find('[data-hidden-control="show"]'),
      this.hideControl = this.el.find('[data-hidden-control="hide"]'),
      this.hiddenEl = this.el.next('[data-hidden-el="true"]'),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        self.showControl.on('click', function() {

          if($(this).is(':checked')) {

            self.hiddenEl.slideDown(settings.speed);

          } else {

            self.hiddenEl.slideUp(settings.speed);

          }

        });

        self.hideControl.on('click', function() {

          if($(this).is(':checked')) {

            self.hiddenEl.slideUp(settings.speed);

          } else {

            self.hiddenEl.slideDown(settings.speed);

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });

  };

  // replicate fields
  $.fn.replicateFields = function() {

    var pluginName = 'replicateFields';

    function Plugin(el) {

      this.el = $(el),
      this.field = this.el.find('[data-replicate-source]'),
      this.maxFields = this.el.attr('data-replicate-max'),
      this.count = 1,
      this.addBtn = this.el.find('.field__add-btn'),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // add new field
        self.addBtn.on('click', function() {

          if (self.count < self.maxFields) {

            self.count++;

            // clone new field
            var newField = self.field.clone();

            // append new field to parent
            newField.insertBefore(self.addBtn);
            //self.el.append(newField);

          }

        });

        // remove existing field
        self.el.on('click', '.field__remove-btn', function(e) {

          $(this).parent().remove();
          self.count--;

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this));

    });

  };

  // overlay
  $.fn.overlay = function(opts) {

    var pluginName = 'overlay',
        defaults = {
          trigger: 'click', // open overlay on click
          delay: 500, // delays opening of overlay
          overlayClass: 'overlay',
          overlayCloseClass: 'overlay__close',
          onComplete: null // callback for when overlay opens
        },
        settings = $.extend({}, defaults, opts);

    function Plugin(el) {

      this.el = $(el),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        // define trigger
        this.trigger = $('button[data-overlay="' + this.el.attr('id') + '"]');

        // if trigger setting is click, open overlay on click of trigger
        if (settings.trigger == 'click') {

          this.trigger.on('click', function() {

            self.openOverlay();

          });

        }

        // if trigger setting is immediate, open overlay when plugin is called
        if (settings.trigger == 'immediate') {

          setTimeout(function() {

            self.openOverlay();

          }, settings.delay);

        }

        // enable closing of overlay
        this.el.find('.' + settings.overlayCloseClass).on('click', function() {

          self.closeOverlay();

        });

      },

      openOverlay: function() {

        var self = this;

        // add enagaged class to body
        $('body').addClass(settings.overlayClass + '-engaged');

        // set opacity to 1, visibility to visible
        this.el.css({
          opacity: 1,
          visibility: 'visible'
        });

        // add active class to overlay, set aria hidden to false
        this.el.addClass(settings.overlayClass + '--active').attr('aria-hidden', false);

        // set aria hidden to true
        $('body > *').not(this.el).attr('aria-hidden', true);

        // bind key pressing
        $doc.bind('keyup', this.keyPressing());

        // if settings has an on complete callback, run it
        if (settings.onComplete) {

          settings.onComplete.call(self);

        }

      },

      closeOverlay: function() {

        // remove enagaged from body
        $('body').removeClass(settings.overlayClass + '-engaged');

        // remove active class to trigger
        this.trigger.removeClass(settings.overlayTriggerClass + '--active');

        // set opacity to 0, visibility to hidden
        this.el.css({
          opacity: 0,
          visibility: 'hidden'
        });

        // remove active class from overlay, set aria hidden to true
        this.el.removeClass(settings.overlayClass + '--active').attr('aria-hidden', true);

        // set aria hidden to false
        $('body > *').not(this.el).attr('aria-hidden', false);

        // unbind key pressing
        $doc.unbind('keyup', this.keyPressing());

      },

      keyPressing: function() {

        var self = this;

        $doc.keyup(function(e) {

          // ESC key closing
          if (e.keyCode == 27) {

            self.closeOverlay();

          }

        });

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this, settings));

    });


  };

  // featuredVideo
  $.fn.featuredVideo = function() {

    var pluginName = 'featuredVideo';

    function Plugin(el) {

      this.el = $(el),
      this.placeholder = this.el.find('.featured-video__placeholder'),
      this.init();

    }

    Plugin.prototype = {

      init: function() {

        var self = this;

        self.placeholder.on('click', function() {

          self.loadVideo();

        });

      },

      loadVideo: function() {

        var self = this,
            videoURL = self.el.attr('data-video-url'),
            iframe = $('<iframe src="' + videoURL + '"></iframe>');

        self.el.append(iframe);

        self.placeholder.hide();

      }

    };

    return this.each(function() {

      $.data(this, pluginName, new Plugin(this));

    });

  };

  function formatDate(date) {

    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');

  }

  var reCaptchaID;

  // callback to load reCAPTCHA
  var renderReCaptcha = function() {

    // prepend reCAPTCHA element to DOM
    var reCaptchaEl = $('<div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lf6OhATAAAAAIydEdqSAkByiIV6KGTeGxnFoYRL"></div>');

    $('.tip-card__recaptcha').prepend(reCaptchaEl);

    // render reCAPTCHA
    reCaptchaID = grecaptcha.render('g-recaptcha', {
      'sitekey' : '6Lf6OhATAAAAAIydEdqSAkByiIV6KGTeGxnFoYRL'
    });

  }

  function init() {

    // add attributes to main element
    $('main').attr({
      'id': 'main',
      'tabindex': -1
    });

    // breakpoint change listener
    $(window).on('breakpointChange', function(e, breakpoint) {

      if(breakpoint === 'bp-sm') {

        // open tip submission overlay in mobile
        // check to see if cookie exists
        if ($.cookie('cs-tip-submission-overlay2015') == null) {

          // set cookie
          $.cookie('cs-tip-submission-overlay2015', 'yes', {
            expires: 7,
            path: '/'
          });

          // open tip submission overlay immediately
          $('#tip-submission-overlay').overlay({
            trigger: 'immediate'
          });

        }

      }

    });

    // breakpoint image replacement
    $('.bp-image').bpImgReplace();

    // navigation
    $('#nav').navigation();

    // tip modal
    $('[data-modal="tip-modal"]').tipModal({

      afterOpen: function() {

        // hidden controls toggling
        $('[data-hidden-control]').hiddenControl();

        // render reCAPTCHA
        new renderReCaptcha();

      }

    });

    // tip form (landing page)
    $('#tip-form').tipForm();

    // crimes slider
    var crimesSlider = $('.crimes-slider');
    if (crimesSlider.length) {

      crimesSlider.slick({
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
          {
            breakpoint: 801,
            settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            }
          },
          {
            breakpoint: 641,
            settings: {
              centerMode: true,
              centerPadding: '60px',
              slidesToShow: 1,
              slidesToScroll: 1,
              variableWidth: true
            }
          }
        ]
      });

    }

    // filters toggling
    $('.filters').togglableContent({
      toggleClass: '.filters__header'
    });

    // date picker on inputs
    var datePickerEl = $('.field__input--date-picker');
    if (datePickerEl.length) {
      datePickerEl.pickadate({
        format: 'm/d/yyyy'
      });
    }

    // photo gallery on crime photos
    var crimePhotoEl = $('.crime-detail__photos__item a');
    if (crimePhotoEl.length) {
      crimePhotoEl.fancybox({
        afterLoad : function() {
          this.title = '<span class="photo-caption">' + (this.title ? this.title : '') + '</span>' + '<span class="photo-count">Photo ' + (this.index + 1) + '/' + this.group.length + '</span>';
        },
        helpers: {
          title: {
            type: 'inside'
          }
        }
      });
    }

    // equal heights on about tip submission blocks
    var aboutTipBlocks = $('.tip-submission__blocks');
    if (aboutTipBlocks.length) {

      aboutTipBlocks.equalHeights({
        className: '.tip-submission__block--alpha'
      });

      aboutTipBlocks.equalHeights({
        className: '.tip-submission__block--beta'
      });

    }

    // IE 8/9 placeholder fallback
    if ($('html').hasClass('ie9') || $('html').hasClass('ie8')) {

      $('.header__search__input, .field__input').placeholder();

    }

    // crime listing filters
    if ($('.crime-filters').length) {

      $('#filter-date-range-from').on('change', function() {
        var dateFrom =  $('#filter-date-range-from').val();
        $('#from').val(formatDate(dateFrom));
      });

      $('#filter-date-range-to').on('change', function() {
        var dateTo =  $('#filter-date-range-to').val();
        $('#to').val(formatDate(dateTo));
      });

      // reset filters
      $('#reset-filters').on('click', function() {

        $('.filters__list__item').each(function() {

          $(this).find('.checkbox__input').attr('checked', false);

        });

      });

    }

    // featured video on homepage
    if ($('.featured-video').length) {

      $('.featured-video').featuredVideo();

    }

  }

  return {
    init: init
  };

}(jQuery));

(function($) {
  'use strict';

  GLOBALS.$doc.ready(function() {

    CRIMESTOPPERS.init();

  });

}(jQuery));