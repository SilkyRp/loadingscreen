function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex ;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}


var neededFiles;
var downloadedFiles = 0;
var youtubePlayer;


function DownloadingFile( fileName ) {
	downloadedFiles++;
	refreshProgress();

	setStatus("Downloading files...");
}

function SetStatusChanged( status ) {
	if (status.indexOf("Getting Addon #") != -1) {
		downloadedFiles++;
		refreshProgress();
	}else if (status == "Sending client info...") {
		setProgress(100);
	}

	setStatus(status);
}

function SetFilesNeeded( needed ) {
	neededFiles = needed + 1;
}

function refreshProgress() {
	progress = Math.floor(((downloadedFiles / neededFiles)*100));

	setProgress(progress);
}

function setStatus(text) {
	$("#status").html(text);
}

function setProgress(progress) {
	$("#loading-progress").css("width", progress + "%");
}

function showMessage(message) {
if (message >= l_messages.length)
	message = 0;

$("#messages").fadeOut(1000, function() {
	$(this).html(l_messages[message]);
	$(this).fadeIn(1000);
});

setTimeout(function() {
	showMessage(message+1);
}, 5000 + 1000*2);
}

var l_messages = [
	"Загружаем аддоны",
	"Заражаем ваш компьютер вирусами",
	"Пишем новые скрипты",
	"Определяем вашу личность",
	"Устанавливаем вам Linux",
	"format C:",
	"sudo make me a sandwich",
	"Открываем еще одно сообщество",
	"Тi шо сервер открыл? (c) SentexKoul",
	"Дудосеры, дудосеры повсюду"
];

$(function() {
	l_messages = shuffle(l_messages);

	showMessage(0);
});

$( document ).ready(function() {
    $('audio').prop('volume', 1);
});
