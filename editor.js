var codeEditor = document.getElementById('codeEditor');
var lineCounter = document.getElementById('lineCounter');

codeEditor.addEventListener('scroll', () => {
    lineCounter.scrollTop = codeEditor.scrollTop;
    lineCounter.scrollLeft = codeEditor.scrollLeft;
});

codeEditor.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
      e.preventDefault();
      codeEditor.setRangeText(
        '\t',
        codeEditor.selectionStart,
        codeEditor.selectionStart,
        'end'
      );
    }
});

var lineCountCache = 0;
function line_counter() {
      var lineCount = codeEditor.value.split('\n').length;
      var outarr = new Array();
      if (lineCountCache != lineCount) {
         for (var x = 0; x < lineCount; x++) {
            outarr[x] = (x + 1) + '.';
         }
         lineCounter.value = outarr.join('\n');
      }
      lineCountCache = lineCount;
};

codeEditor.addEventListener('input', () => {
    line_counter();
});

line_counter();