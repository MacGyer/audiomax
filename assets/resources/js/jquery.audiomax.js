(function($){
    $.audiomax = function(el, options){
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;
        
        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.$elInner = base.$el.children('.inside');
        base.el = el;
        
        // Add a reverse reference to the DOM object
        base.$el.data("audiomax", base);
        
        // properties
        base.currentAudio = 0;
        
        // private functions
        function createPlaylist()
        {
            var $playlist = $('<ul></ul>', {"id": "playlist"});
            var objPlaylist = base.options.playlist;
            var i = 0;
            
            for(i; i < objPlaylist.length; i++)
            {
                $playlist.append('<li>' + objPlaylist[i]['interpreter'] + ' - ' + ((objPlaylist[i]['album'] != '') ? objPlaylist[i]['album'] + ' - ' : '') + ((objPlaylist[i]['track'] != '') ? objPlaylist[i]['track'] + ' - ' : '') + objPlaylist[i]['title']);
            }
            $playlist.children('li:first-child').attr('data-current', 'true').addClass('active');
            return $playlist;
        }
        
        function createControls()
        {
            var $controls = $('<ul></ul>', {"id": "controls"});
            var objButtons = base.options.controls;
            
            for(key in objButtons)
            {
                var $li = $('<li></li>', {
                    "data-controls": key,
                    "text": objButtons[key],
                    "title": objButtons[key]
                });
                $controls.append($li);
            }
            $controls.children('li[data-controls="play"]').attr('data-state', 'null');
            $controls.children('li[data-controls="volume"]').attr('data-state', 'volumeOn');
            return $controls;
        }
        
        function createVolumeBar()
        {
            var $volumeContainer = $('<div></div>', {
                "id": 'volume'
            });
            var $volumeBar = $('<meter></meter>', {
                "min": 0,
                "max": 1,
                "value": base.options.initVolume
            });
            $volumeContainer.append($volumeBar);
            $volumeContainer.append('<span>' + displayVolumeValue(base.options.initVolume) + '</span>');
            
            return $volumeContainer;
        }
        
        function displayVolumeValue(vol)
        {
            return parseInt(vol * 100) + '%';
        }
        
        function calculateVolume(clickPosition)
        {
            var volume;
            var barWidth = $('#volume meter').width();
            volume = (clickPosition * 100 / barWidth) / 100; // in % (0 ... 1)
            volume = new String(volume);
            return volume.slice(0, 4);
        }
        
        function createProgressBar()
        {
            var $progressContainer = $('<div></div>', {
                "id": 'playerInfo'
            });
            var $progressBar = $('<progress></progress>', {
                "min": 0,
                "max": 1,
                "value": 0
            });
            $progressContainer.append($progressBar);
            $progressContainer.append('<span>' + displayProgressValue(0) + '</span>');
            
            return $progressContainer;
        }
        
        function calculateProgress(clickPosition)
        {
            var progress, played, currentTime, objProgress;
            var barWidth = $('#playerInfo progress').width();
            
            // if click event has not been triggered (event listener)
            if(clickPosition == undefined)
            {
                played = base.audio.currentTime / base.audio.duration;
            }
            else{
                played = (clickPosition * 100 / barWidth) / 100; // played part in %
            }
            
            currentTime = base.audio.duration * played;
            objProgress = {
                currentTime: currentTime,
                played: played
            };
            
            return objProgress;
        }
        
        function displayProgressValue(time)
        {
            var objTime = new Date(time * 1000);
            var formattedTime = ('0' + objTime.getMinutes()).slice(-2) + ':' + ('0' + objTime.getSeconds()).slice(-2);

            return formattedTime;
        }
        
        function getClickPosition(elem, event){
            var x = event.pageX - elem.offset()['left'];
            return x;
        }
        
        base.init = function()
        {
            base.options = $.extend({},$.audiomax.defaultOptions, options);
            
            // Display Playlist Title
            if(base.options.title !== 'null')
            {
                base.$elInner.append('<div class="playlistTitle">' + base.options.title + '</div>');
            }
            
            // Display Playlist Description
            if(base.options.description !== 'null')
            {
                base.$elInner.append('<div class="playlistDescription">' + base.options.description + '</div>');
            }
            
            // Display the Playlist
            if(base.options.playlist !== null && typeof base.options.playlist === 'object')
            {
                base.$elInner.append(createPlaylist());
            }
            
            // Display Progress Bar
            base.$elInner.append(createProgressBar());
            
            // Display controls
            base.$elInner.append(createControls());
            
            // Display Volume Bar
            base.$elInner.append(createVolumeBar());
            
            // Load the first track
            base.audioCreate(base.getTrackIndex('current'));
            
            // set the volume to default
            base.audio.volume = base.options.initVolume;
        };
        
        // initialize the file
        base.audioCreate = function(trackIndex)
        {
            base.audio = new Audio();
            var files = base.options.playlist[trackIndex]['files'];
            
            for(var key in files)
            {
                if(base.audio.canPlayType(files[key]['type']) != '' && base.audio.canPlayType(files[key]['type']) != 'no')
                {
                    base.audio.src = files[key]['file'];
                    break;
                }
            }
            base.audio.preload = base.options.preload;
        };
        
        // play the file
        base.audioPlay = function()
        {
            base.audio.play();
            $('#controls li[data-controls="play"]').attr('data-state', 'play');
            
            // update timer
            base.audio.addEventListener('timeupdate', function(){
                var currentTime = displayProgressValue(base.audio.currentTime);
                var $progressBar = $('#playerInfo progress');
                $progressBar.next().text(currentTime);
        
                // TODO: update value of progress
                var objProgress = calculateProgress();
                $progressBar.val(objProgress.played);
            });
            
            base.audio.addEventListener('ended', function(){
                base.audioCreate(base.getTrackIndex('next'));
                base.audioPlay();
            });
        };
        
        // pause the file
        base.audioPause = function()
        {
            base.audio.pause();
            $('#controls li[data-controls="play"]').attr('data-state', 'pause');
        };
        
        // set the status of currently played track
        base.setCurrentStatus = function($elem)
        {
            $('#playlist li').removeAttr('data-current').removeClass('active');
            $elem.attr('data-current', 'true').addClass('active');
        };
        
        // set the volume
        base.audioVolume = function($elem, event)
        {
            var volume = calculateVolume(getClickPosition($elem, event));
            $elem.attr('value', volume);
            $elem.next().text(displayVolumeValue(volume));
            base.audio.volume = volume;
        };
        
        // switch on/off audio
        base.audioToggle = function(state)
        {
            var $volumeBar = $('#volume meter');
            
            if(state == 'on')
            {
                base.audio.volume = base.currentVolume;
                $volumeBar.next().text(displayVolumeValue(base.currentVolume));
                console.log(base.currentVolume);
                $volumeBar.attr('value', base.currentVolume);
            }
            else if(state == 'off')
            {
                base.currentVolume = base.audio.volume;
                base.audio.volume = 0;
                $volumeBar.next().text(displayVolumeValue(0));
                $volumeBar.attr('value', 0);
            }
        };
        
        // set the progress
        base.audioProgress = function($elem, event)
        {
            var objProgress = calculateProgress(getClickPosition($elem, event));
            $elem.attr('value', objProgress['played']);
            $elem.next().text(displayProgressValue(objProgress['currentTime']));
            base.audio.currentTime = objProgress['currentTime'];
        };
                
        // get track index
        base.getTrackIndex = function(location)
        {
            var index;
            var $track;
            
            if(location == 'current')
            {
                $track = base.$el.find('li[data-current="true"]');
            }
            else if(location == 'next')
            {
                $track = base.$el.find('li[data-current="true"]').next();
                if($track.length == 0)
                {
                    $track = base.$el.find('#playlist li:first-child');
                }
            }
            else if(location == 'prev')
            {
                $track = base.$el.find('li[data-current="true"]').prev();
                if($track.length == 0)
                {
                    $track = base.$el.find('#playlist li:last-child');
                }
            }
            base.setCurrentStatus($track);
            
            index = $track.index();
            return index;
        };
        
        // Run initializer
        base.init();
    };
    
    $.audiomax.defaultOptions = {
        title:      "null",
        playlist:   "null",
        preload:    'auto',
        description: "null",
        controls:   {
            prev:   'previous',
            play:   'play/pause',
            next:   'next',
            volume: 'Sound on/off'
        },
        initVolume: 0.6
    };
    
    $.fn.audiomax = function(options){
        return this.each(function(){
            var audiomax = new $.audiomax(this, options);
            
            // when user clicks play/pause button
            $('#controls li[data-controls="play"]').click(function(){
                var $this = $(this);
                var state = $this.attr('data-state');
                
                if(state == null || state == 'null' || state == 'pause')
                {
                    audiomax.audioPlay();
                }
                else if(state == 'play')
                {
                    audiomax.audioPause();
                }
                
            });
            
            // when user clicks next button
            $('#controls li[data-controls="next"]').click(function(){
                var $this = $(this);
                
                if(typeof audiomax.audio === 'object')
                {
                    audiomax.audioPause();
                }
                audiomax.audioCreate(audiomax.getTrackIndex('next'));
                audiomax.audioPlay();
            });
            
            // when user clicks prev button
            $('#controls li[data-controls="prev"]').click(function(){
                var $this = $(this);
                
                if(typeof audiomax.audio === 'object')
                {
                    audiomax.audioPause();
                }
                audiomax.audioCreate(audiomax.getTrackIndex('prev'));
                audiomax.audioPlay();
            });
            
            // when user clicks a playlist element
            $('#playlist li').click(function(e){
                var $this = $(this);
                
                audiomax.setCurrentStatus($this);
                if(typeof audiomax.audio === 'object')
                {
                    audiomax.audioPause();
                }
                audiomax.audioCreate(audiomax.getTrackIndex('current'));
                audiomax.audioPlay();
            });
            
            // when user clicks progress bar
            $('#playerInfo progress').click(function(e){
                var $this = $(this);
                audiomax.audioProgress($this, e);
            });
            
            // when user clicks volume bar
            $('#volume meter').click(function(e){
                var $this = $(this);
                audiomax.audioVolume($this, e);
            });
            
            // when user clicks volume button
            $('#controls li[data-controls="volume"]').click(function(){
               var $this = $(this);
               var state = $this.attr('data-state');
               
               if(state == 'volumeOn')
               {
                   audiomax.audioToggle('off');
                   $this.attr('data-state', 'volumeOff');
               }
               else if(state == 'volumeOff')
               {
                   audiomax.audioToggle('on');
                   $this.attr('data-state', 'volumeOn');
               }
            });
        });
    };
    
})(jQuery);