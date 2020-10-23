function run_waitMe(el, num, effect){
     text = 'Please wait...';
     fontSize = '';
     switch (num) {
         case 1:
         maxSize = '';
         textPos = 'vertical';
         break;
         case 2:
         text = '';
         maxSize = 30;
         textPos = 'vertical';
         break;
         case 3:
         maxSize = 30;
         textPos = 'horizontal';
         fontSize = '18px';
         break;
     }
     el.waitMe({
         effect: effect,
         text: text,
         bg: 'rgba(255,255,255,0.7)',
         color: '#000',
         maxSize: maxSize,
         waitTime: -1,
         source: 'img.svg',
         textPos: textPos,
         fontSize: fontSize,
         onClose: function(el) {}
     });
 }
 function run_waitMe_body(effect){
     $('body').addClass('waitMe_body');
     var img = '';
     var text = '';
     if(effect == 'img'){
         img = 'background:url(\'img.svg\')';
     } else if(effect == 'text'){
         text = 'Loading...'; 
     }
     var elem = $('<div class="waitMe_container ' + effect + '"><div style="' + img + '">' + text + '</div></div>');
     $('body').prepend(elem);
     
     setTimeout(function(){
         $('body.waitMe_body').addClass('hideMe');
         setTimeout(function(){
             $('body.waitMe_body').find('.waitMe_container:not([data-waitme_id])').remove();
             $('body.waitMe_body').removeClass('waitMe_body hideMe');
         },200);
     },4000);
 }