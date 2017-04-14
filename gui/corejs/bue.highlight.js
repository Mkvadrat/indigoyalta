/**
 * BUEditor Syntax Highlighter by ufku.com.
 * Requires: none
 * Usage: E.highlight('html');
 */
(function(E, $) {

// Cache for general use
var cache = {};

// Add browser classes to html element
// Set values for browser anomalies in textarea padding
cache.hpad = 0;
cache.vpad = 0;
var $html = $('html'), bver = parseInt($.browser.version);
if ($.browser.mozilla) {
  cache.hpad = 2.5;
  $html.addClass('mozilla mozilla-'+ bver);
}
else if ($.browser.safari || $.browser.webkit) {
  if (window.chrome) {
    $html.addClass('chrome');
  }
  else {
    $html.addClass('safari');
  }
  cache.vpad = 3;
  $html.addClass('webkit webkit-'+ bver);
}
else if ($.browser.opera) {
  $html.addClass('opera opera-'+ bver);
}
else if ($.browser.msie) {
  $html.addClass('ie ie-'+ bver);
}

// Delay the function execution until the current event completes
var delay = function(func, arg) {
  setTimeout(function() {
    func(arg);
  });
};

// Textarea event to update the highlight
var eUpdate = function(e) {
  delay(BUE.hlUpdate, this);//run just after the current event
};

// Equalize scrolltops
var syncScrl = function(T) {
  T.colayer.scrollTop = T.scrollTop;
};

// Handle textarea's regular scroll event
var eScrl = function() {
  var T = this;
  syncScrl(T);
  delay(syncScrl, T);//run again just after the event complete
};

// Handle textarea scroll which is triggered by mouse drag.
var eDragScrl = function() {
  var T = this, $doc = $(document);
  //syncronize scrollTop
  var drag = function() {
    syncScrl(T);
  };
  var enddrag = function() {
    $doc.unbind('mousemove', drag).unbind('mouseup', enddrag);
    syncScrl(T);
  };
  $doc.mousemove(drag).mouseup(enddrag);
};

// Mousedown event of textarea resizer
var grippieResize = function() {
  var T = this.bueT, $T = $(T), $L = $(T.colayer), $doc = $(document);
  // Syncronize heights
  var drag = function() {
    $L.height($T.height() - (cache.vpad || 0));
    return false;
  };
  var enddrag = function() {
    $doc.unbind('mousemove', drag).unbind('mouseup', enddrag);
    syncScrl(T);
  };
  $doc.mousemove(drag).mouseup(enddrag);
};

// Alternate content setter for the editor instance which updates the highlighting
var setContent = function () {
  eUpdate.call(this.textArea);
  return this.hlOriginalSetContent.apply(this, arguments);
};

// Browser specific syncron. some need some dont.
var syncBrw = $.browser.msie || $.browser.opera ? syncScrl : function() {};

// Container for syntax highlihgters.
BUE.hlighters = BUE.hlighters || {};
// Cache for html highlighter.
var hcache = {};
// Ampersand
var r1 = /&/g, s1 = '&amp;';
// Html start/end tag
var r2 = /<(\/?([a-z][a-z0-9]*)[^<>]*>?)/g, s2 = '<span class="bue-hl-tag bue-hl-tag-$2">&lt;$1</span>';
// Uncaugth lt char
var r3 = /<(?!\/?s)/g, s3 = '&lt;';
// IE whitespace replacer
var rIE = $.browser.msie && /^\s|\s(?=\s)|\s$/g, sIE = '&nbsp;';

//HTML syntax highlighter(line based)
BUE.hlighters.html = function(str, raw) {
  var undefined, line, cached, R1 = r1, R2 = r2, R3 = r3, S1 = s1, S2 = s2, S3 = s3;
  var lines = str.split('\n'), len = lines.length, output = '';
  //create output for each line and get/set strings from/to cache.
  for (var i = 0; i < len; i++) {
    line = lines[i];
    cached = hcache[line];
    if (cached === undefined) {
      hcache[line] = cached = line.replace(R1, S1).replace(R2, S2).replace(R3, S3);
    }
    lines[i] = cached;
  }
  return raw ? lines : BUE.hlProcessLines(lines);
};

// Returns html representation of lines returned by a highlighter.
BUE.hlProcessLines = function(lines, cname) {
  if (!lines || !lines.length) return '';
  // Handle whitespaces for IE.
  if (rIE) for (var i in lines) {
    lines[i] = lines[i].replace(rIE, sIE);
  }
  var span = '<span' + (cname ? ' class="' + cname + '"' : '') + '>';
  var output = span + lines.join('<br /></span>' + span) + '<br /></span>';
  return output;
};

// Do fulltext highlighting
BUE.hlFullText = function(T) {
  //innerHTML is fast.
  T.colayer.innerHTML = BUE.hlighters[T.colang](BUE.text(T.value));
  //wait the dom to be updated
  delay(syncScrl, T);
};

// Track changes in textarea and update highlighting.
BUE.hlUpdate = function(T) {
  //no need for highlighting
  if (cache.tvalue == T.value) {
    return syncBrw(T);
  }

  // Cache the values
  var oldvalue = cache.tvalue;
  cache.tvalue = T.value;

  // The whole content has changed.
  if (!oldvalue || !T.value) {
    return BUE.hlFullText(T);
  }
  
  // Get current lines
  var newlines = BUE.text(T.value).split('\n'), newlen = newlines.length;
  // Get old lines
  var oldlines = BUE.text(oldvalue).split('\n'), oldlen = oldlines.length;
  // Get dom equivalents of the current lines
  var L = T.colayer, olddom = L.childNodes;

  // Find the index of the first different line.
  for (var i = 0; i < newlen; i++) {
    if (newlines[i] != oldlines[i]) break;
  }
  // Find the index of the last different line.
  for (var j = newlen - 1, k = oldlen -1;  i < j && i < k; j--, k--) {
    if (newlines[j] != oldlines[k]) break;
  }

  // Create replacement html
  var hlfunc = BUE.hlighters[T.colang], html = '';
  for (var n = i; n <= j; n++) {
    html += hlfunc(newlines[n]);
  }

  // If we are replacing all the old lines then use the faster replacement method
  if (i == 0 && k == oldlen - 1) {
    L.innerHTML = html;
    return syncBrw(T);
  }

  // Create the replacer dom lines
  var newdom = html ? BUE.$html(html).get() : [];

  // The first diff index > the last diff index => means new line(s) added to the end.
  if (k < i) {
    $(L).append(newdom);
    return syncBrw(T);
  }

  // Remove old different lines, except the last one
  for (n = i; n < k; n++) {
    L.removeChild(olddom[i]);
  }
  // Replace the last one with the newdom
  $(olddom[i]).replaceWith(newdom);

  // IE needs syncron all the time
  syncBrw(T);
  return;
};

// Create and return the color layer that mimics the textarea.
BUE.hlColayer = function(T) {
  if (T.colayer) {
    return T.colayer;
  }
  var L = T.colayer = document.createElement('div');
  var P = T.colayerParent = document.createElement('div');
  $(L).addClass('bue-hl-layer bue-hl-colayer').attr({id: T.id + '-bue-hl-colayer'});
  $(P).addClass('bue-hl-colayer-parent').attr({id: T.id + '-bue-hl-colayer-parent'}).append(L);
  return L;
};

// Enable highlighting of the textarea with lang syntax
BUE.hlEnable = function(T, lang) {
  if (T.colayerParent && $(T.colayerParent).css('display') != 'none') {
    return true;
  }
  if (!BUE.hlighters[lang] || !T.offsetWidth) {
    return false;
  }
  var $T = $(T), E = T.bue, $grp = $T.next('.grippie'), pos = BUE.selPos(T), scrl = T.scrollTop;
  
  // Rewrite setContent method of editor instance in order to trigger highlighting
  E.hlOriginalSetContent = E.setContent;
  E.setContent = setContent;

  // Create layer
  BUE.hlColayer(T);
  
  // Set highlight lang
  T.colang = lang;

  // Revise textarea resizing.
  if ($grp.size()) {
    $grp[0].bueT = T;
    $grp.mousedown(grippieResize);
  }

  // Update the highlight on keydown & click & possible drag & drop text
  $T.keydown(eUpdate).click(eUpdate).bind('drop', eUpdate);
  
  //Set the events for scrollTop syncron.
  $T.scroll(eScrl).mousedown(eDragScrl);
  // Opera does not fire scroll on textareas. Also passing events to the underlay. No workaround.(#284484)
  $.browser.opera && $T.bind('mousewheel', T.weirdOScroll = function() {
    var T = this;
    syncScrl(T);
    // Run again after some time?
    setTimeout(function() {syncScrl(T)}, 400);
  });
  // IE weirdly changes the textarea scroll on window scroll.
  $.browser.msie && $(window).scroll(T.weirdIEScroll = function(){syncScrl(T)});
  
  // Insert the color layer into DOM. Insert before preview or textarea.
  var $P = $(T.colayerParent), nextEl = $T.prev('.preview').add(T)[0];
  $P.next()[0] != nextEl && $P.insertBefore(nextEl);
  $P.css({display: 'block'});

  // Add styles to the textarea
  $T.addClass('bue-hl-layer bue-hl-textarea');

  // Recalculate the width & height and adjust shifts in padding
  var width = $T.width() - (cache.hpad || 0);
  var height = $T.height() - (cache.vpad || 0);
  $(T.colayer).css({height: height, width: width});

  // Highlight the code for the first time
  BUE.hlUpdate(T);
  
  // Restore selection & scroll
  BUE.selMake(T, pos.start, pos.end);
  T.scrollTop = scrl;

  return true;
};

// Disable highlighting and restore the textarea
BUE.hlDisable = function(T) {
  if (!T.colayerParent || $(T.colayerParent).css('display') == 'none') {
    return true;
  }
  var $T = $(T), E = T.bue, $grp = $T.next('.grippie'), pos = BUE.selPos(T), scrl = T.scrollTop;

  // Restore content setter
  E.setContent = E.hlOriginalSetContent;
  
  // Hide color layer
  $(T.colayerParent).css({display: 'none'});

  // Restore textarea styles
  $T.removeClass('bue-hl-layer bue-hl-textarea');

  // Unbind events
  $T.unbind('keydown', eUpdate).unbind('click', eUpdate).unbind('drop', eUpdate);
  $T.unbind('scroll', eScrl).unbind('mousedown', eDragScrl);
  $.browser.opera && $T.unbind('mousewheel', T.weirdOScroll);
  $.browser.msie && $(window).unbind('scroll', T.weirdIEScroll);

  // Restore grippie
  if ($grp.size()) {
    $grp.unbind('mousedown', grippieResize);
  }

  // Restore selection & scroll
  BUE.selMake(T, pos.start, pos.end);
  T.scrollTop = scrl;

  return true;
};

// Set highlight shortcut. Ctrl+Alt+H
BUE.preprocess.highlight = function(E, $) {
  $(E.textArea).keydown(function(e) {
    if (e.ctrlKey && e.originalEvent.altKey && e.keyCode == 72) {
      var T = this, E = T.bue;
      E.highlight(E.highlightOn ? false : (T.colang || 'html'));
      return false;
    }
  });
};

/**
 * Editor instance method to turn highlight on/off
 *
 * @param lang
 *   Boolean false turning the highlight off.
 *   String highlight type turning the highlight on.
 *     - BUE.hlighters.lang must have been defined in order to use the lang type.
 * @return
 *   The editor instance.
 */
E.highlight = function(lang) {
  var E = this, T = E.textArea;
  if (E.highlightOn) {
    if (lang) {
      return E;
    }
    E.highlightOn = !BUE.hlDisable(T);
  }
  else {
    if (!lang) {
      return E;
    }
    E.highlightOn = BUE.hlEnable(T, lang);
  }
  return E;
};

})(BUE.instance.prototype, jQuery);

/*
Highlighting is off by default and can be turned on/off using the shortcut: Ctrl+Alt+H

You can alternatively add a switch button with the content
js:
E.highlight(E.highlightOn ? false : 'html');
E.stayClicked(E.highlightOn).focus();

Or you can initially enable the highlighting by defining a template button(having the title "tpl:") with the content
js:
BUE.postprocess._yourprocessname = function(E, $){
  setTimeout(function(){E.highlight('html')});
};

*/
