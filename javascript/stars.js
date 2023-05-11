function setStars(i) {
    for (var index = 0; index <= i; index++) {
        document.getElementById(index+1).className = 'fa fa-star';
    }
    for (var index = i+1; index <= 5; index++) {
        document.getElementById(index).className = 'far fa-star';
    }
    document.getElementById("stars").value = i;
}