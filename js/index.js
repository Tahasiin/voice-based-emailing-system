var alertInfo = document.getElementById('alertInfo')
var listenBtn = document.getElementById('start_button')
var final_span = document.getElementById("final_span");
var interim_span = document.getElementById("interim_span");
var recognizing = false;
var final_transcript = '';


//Check if speech recoginition is supported
//**** This may need to be adjusted for mobile browsers
if (!('webkitSpeechRecognition' in window)) {

    //Indicate support 
    start_button.style.display = 'none';
    select_language.style.display = 'none';
    select_dialect.style.display = 'none';
    alertInfo.innerHTML = "Sorry, this browser doesn't support web speech";

} else {

    //init speech
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true; // continous listing
    recognition.interimResults = true;

    recognition.onstart = function () {
        recognizing = true;
        alertInfo.innerHTML = "Speak Now.";
        listenBtn.innerHTML = "Stop Listening"
    };

    recognition.onresult = function () {
        console.log("tst")
        var interim_transcript = '';

        for (var i = event.resultIndex; i < event.results.length; ++i) {

            if (event.results[i].isFinal) {
                final_transcript += event.results[i][0].transcript;
            } else {
                interim_transcript += event.results[i][0].transcript;
            }

        }

        final_transcript = capitalize(final_transcript);
        final_span.innerHTML = linebreak(final_transcript);
        interim_span.innerHTML = linebreak(interim_transcript);

    };

    recognition.onerror = function () {

    };

    recognition.onend = function () {
        recognizing = false;
        listenBtn.innerHTML = "Start Listening"
        alertInfo.innerHTML = "Click button to listen.";
    };

}

//Text Formatting
var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
    return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}
var first_char = /\S/;
function capitalize(s) {
    return s.replace(first_char, function (m) {
        return m.toUpperCase();
    });
}

//click Listen Button
function startButton(event) {

    //Handle Stop
    if (recognizing) {
        recognition.stop();
        return;
    }

    final_transcript = '';
    recognition.lang = select_dialect.value;
    recognition.start();

}



//        -----------------
$("final_span, #field2").keyup(function () {
    update();
});

function update() {
    $("#copy").val($('#final_span').val() + " " + $('#field2').val());
}