export default { 
  capFirstLetter(val) {
    if (!val) return ''
    return val.charAt(0).toUpperCase() + val.slice(1);
  },
  doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
      
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
  },
  limitText(string) {
    return string.substring(0,34) + '...';
  },
  limitTextFlex(string, limit) {
    return string.substring(0,limit) + '...';
  },
  definedLimitText(string, limit=60) {
    return string.substring(0,limit) + '...';
  },
  fnCompRate(sum, count){
    var x = [];
    var f = parseInt((sum / count));
    for (let i = 0; i < f; i++) {
      x.push(i);
    }
    return x;
  },
  exactLimitText(t, count){
    if (typeof t !== 'undefined') {
      return t.slice(0, count) + (t.length > count ? "..." : "");
    }
  }
};