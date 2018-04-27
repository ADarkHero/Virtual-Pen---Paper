function rolld20(){
    rolldice(20)
}

function rolld6(){
    rolldice(6);
}

function rolldice(d){
    var dicediv = "#d"+d;
    $(dicediv).addClass('headerdiceanimation');
    dicenumbers(d);
    setTimeout(function() { 
        $(dicediv).removeClass('headerdiceanimation');
    }, 2000);
}

function dicenumbers(d){
    var dicediv = "#d"+d;
    setTimeout(function() { 
        var x = Math.floor((Math.random() * d) + 1);
        document.getElementById("diceroll").innerHTML = x;
        if($(dicediv).hasClass('headerdiceanimation')){
           dicenumbers(d);   
        }
    }, 50);
}