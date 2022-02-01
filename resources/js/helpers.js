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
  fnCompRate(sum, count){
    var x = [];
    var f = parseInt((sum / count));
    for (let i = 0; i < f; i++) {
      x.push(i);
    }
    return x;
  }
};