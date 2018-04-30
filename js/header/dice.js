function rolld20(){
    rolldice(20);
}

function rolld6(){
    rolldice(6);
}

var x;
function rolldice(d){
    var dicediv = "#d"+d;
    if($("#diceroll").hasClass('headernumberanimation')){
        
    }
    $(dicediv).addClass('headerdiceanimation');
    dicenumbers(d);
    setTimeout(function() { 
        $(dicediv).removeClass('headerdiceanimation');
        setTimeout(function() {
            if(x === d || x === 1){
                $("#diceroll").addClass("headernumberanimation");
                setTimeout(function(){
                    $("#diceroll").removeClass("headernumberanimation");
                },2000);
            }
        }, 100);
    }, 1000);
}

function dicenumbers(d){
    var dicediv = "#d"+d;
    setTimeout(function() { 
        x = Math.floor((Math.random() * d) + 1);
        document.getElementById("diceroll").innerHTML = x;
        if($(dicediv).hasClass('headerdiceanimation')){
           dicenumbers(d);   
        }
    }, 50);
}