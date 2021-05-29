$(document).ready(function(){

    // On Click Sign up Hide Login

    $("#signup").click(function(){
        $("#first").slideUp("fast", function(){
            $("#second").slideDown("fast")
        })
    })
    $("#signin").click(function(){
        $("#second").slideUp("fast", function(){
            $("#first").slideDown("fast")
        })
    })



})