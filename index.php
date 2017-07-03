<?php
include('config.php');

$songnum = rand(0,(sizeof($songs) / 2) - 1);
$song = $songs[$songnum];
$songname = $songs[$songnum+(sizeof($songs) / 2)];
?>
<html>
    <head>
        <meta name="viewport" content="width=1 initial-scale=1.0">
    </head>
    <style>
        @font-face {
            font-family: Kano;
            src: url("assets/font/Kano.otf") format("opentype");
        }
        body{
            background-image: url(<?php print($bgimg); ?>);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }    
        #info{
            font-family: Kano;
        }
        #myProgress {
    position: relative;
    width: 100%;
    height: 30px;
    background-color: <?php print($progbarback); ?>;
}
#myBar {
    position: absolute;
    width: 0%;
    height: 100%;
    background-color: <?php print($curprogcolor); ?>;
}
        #label {
    text-align: center; /* If you want to center it */
    line-height: 30px; /* Set the line-height to the same as the height of the progress bar container, to center it vertically */
    color: white;
            font-family: Kano;
        }
    </style>
<body>
<audio id="audio" src="<?php print($song); ?>" autoplay loop>
  Your browser does not support the <code>audio</code> element.
</audio>
    <div style="width: 100%; height:100%; font-size: 1.3vw">
     <div id="profile" style="background-color: <?php print($infoboxcolor); ?>; width: 20em; height: 6em; position: absolute; left: 73.5%;">
    <img class="avatar" style="position: absolute; top: 12%; left:2%; width: 4em" src="assets/img/speaker.png" />
    <div id="info">
        <p class="clan" style="color: white; position: absolute; top: 0%; left: 25%;">Song:</p>
        <p class="clan" style="color: white; position: absolute; top: 28%; left: 25%;"><?php print($songname); ?></p>
        </div>
    <div id="bar" style="background-color: <?php print($infobarcolor); ?>; width: 100%; height: 7%; position: absolute; top: 90%;">
        
</div>
         </div>
       
<div style="width: 100%; height:100%; font-size: 1.1vw"> <!-- AUTO SIZE -->

        
    <script>
         
    var elem = document.getElementById("myBar"); 
    function frame(widtha) {
            elem.style.width = widtha + '%'; 
            document.getElementById("label").innerHTML = widtha * 1 + '%';
        }
     (function () {
    'use strict';

    var LOAD = {};

    /**
     * Initialize the loading screen.
     */
    LOAD.init = function () {
        this.progress = 0.0;
        this.filesNeeded = 1;
        this.filesTotal = 1;

        this.$ = {};

        // loading bar
        this.$.progressBar = document.getElementById('progressbar');
        this.$.status = document.getElementById('status');
        this.$.percentage = document.getElementById('percentage');

        // server info
        this.$.mapPreview = document.getElementById('mappreview');
        this.$.serverName = document.getElementById('servername');
        this.$.mapName = document.getElementById('mapname');
        this.$.playerSlots = document.getElementById('playerslots');

        this.updateProgress();
    };

    /**
     * Set the total number of files to be downloaded. This will be called on
     * the `SetFilesTotal` loading screen event.
     */
    LOAD.setFilesTotal = function (numFiles) {
        this.filesTotal = Math.max(0, numFiles);
    };

    /**
     * Sets the number of files needed to be downloaded. This will be called on
     * the `SetFilesNeeded` loading screen event.
     */
    LOAD.setFilesNeeded = function (numFiles) {
        this.filesNeeded = Math.max(0, numFiles);
    };

    /**
     * Sets the server info data on the loading screen. This will be called on
     * the `GameDetails` loading screen event.
     */
    LOAD.setServerInfo = function (serverName, mapName, maxPlayers) {
        // set map preview image
        // this.$.mapPreview.src = 'asset://mapimage/' + mapName;

        // gametracker.com map previews can also be used
        this.$.mapPreview.src = 'http://image.www.gametracker.com/images/maps/160x120/garrysmod/' + mapName + '.jpg';

        this.$.mapName.innerText = mapName;
        this.$.serverName.innerText = serverName;
        this.$.playerSlots.innerText = maxPlayers + ' player slots';
    };

    /**
     * Updates the progress bar on the loading screen.
     */
    LOAD.updateProgress = function () {
        var filesRemaining = Math.max(0, this.filesTotal - this.filesNeeded),
            progress = (this.filesTotal > 0) ?
                (filesRemaining / this.filesTotal) : 1;

        progress = Math.round(progress * 100);

        frame(progress)
    };

    /**
     * Called on the `DownloadingFile` loading screen event.
     * Updates the loading progress and shows which file is currently being
     * downloaded.
     */
    LOAD.onFileDownloading = function (filePath) {
        this.filesNeeded = Math.max(0, this.filesNeeded - 1);
        this.updateProgress();

        var status = 'Downloading ' + filePath + '...';
        this.onStatusChanged(status);
    };

    /**
     * Called on the `SetStatusChanged` loading screen event.
     */
    LOAD.onStatusChanged = function (status) {
        // final status
        if (status === 'Sending client info...') {
            this.filesNeeded = 0;
            this.updateProgress();
        }

        this.$.status.innerText = status;
    };

    LOAD.init();
    window.LOAD = LOAD;

    /**
     * Called when the loading screen finishes loading all assets.
     *
     * @param {String} serverName Server name.
     * @param {String} serverUrl  Server loading screen URL.
     * @param {String} mapName    Map name.
     * @param {Number} maxPlayers Maximum players.
     * @param {String} steamid    64-bit Steam ID.
     * @param {String} gamemode   Gamemode folder name.
     */
    window.GameDetails = function (serverName, serverUrl, mapName, maxPlayers, steamid, gamemode) {
        LOAD.setServerInfo(serverName, mapName, maxPlayers);
    };

    /**
     * Called when a file starts downloading. The filename includes the entire
     * path of the file; for example "materials/models/bobsModels/car.mdl".
     *
     * @param {String} filePath Full file path.
     */
    window.DownloadingFile = function (filePath) {
        LOAD.onFileDownloading(filePath);
    };

    /**
     * Called when something happens. This might be "Initialising Game Data",
     * "Sending Client Info", etc.
     *
     * @param {String} status Loading status.
     */
    window.SetStatusChanged = function (status) {
        LOAD.onStatusChanged(status);
    };

    /**
     * Called at the start, tells us how many files need to be downloaded in
     * total.
     *
     * @param {String} total Total files to be downloaded.
     */
    window.SetFilesTotal = function (total) {
        LOAD.setFilesTotal(total);
    };

    /**
     * Called when the number of files to download changes.
     *
     * @param {String} needed Number of files needed to download.
     */
    window.SetFilesNeeded = function (needed) {
        LOAD.setFilesNeeded(needed);
    };
}());

    </script>
<?php
$id = $_GET["id"];
if(is_numeric($id)){
	
}else{

}
$map = $_GET["map"];
 $authserver = bcsub( $id, '76561197960265728' ) & 1;
    $authid = (bcsub( $id, '76561197960265728' ) - $authservers ) / 2 -0.5;
    $steamid = "STEAM_0:$authserver:$authid";
    
// Create connection
$conn = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
     
    $sql = "SELECT id, _SteamID, _Money, _Igname, _TimePlayed FROM players WHERE _SteamID='" . $steamid . "' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       

$link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=034EB8FE4AD3A918F09FE486FE168B69&steamids=' . $id . '&format=json');

$myarray = json_decode($link, true);
        
        function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    $data = $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
        $data = explode(", ", $data);
        if($data[0] == "0 days"){
            return $dtF->diff($dtT)->format('%h hours, %i minutes');
        }elseif($data[1]=="0 hours"){
            return $dtF->diff($dtT)->format('%i minutes');
        }else{
            return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
        }
}
?>

<div id="profile" style="background-color: <?php print($infoboxcolor); ?>; width: 25em; height: 10em; position: relative;">
    <img class="avatar" style="position: absolute; top: 5%; left:2%; width: 4em" src="<?php print $myarray['response']['players'][0]['avatarmedium']; ?>" />
    <div id="info">
    <p class="name" style="color: white; position: absolute; top: 3%; left: 20%;">Name: <?php print $row["_Igname"]; ?></p>
        <p class="bal" style="color: white; position: absolute; top: 15%; left: 20%;">Balance: <?php print "$" . number_format($row["_Money"]); ?></p>
        <p class="clan" style="color: white; position: absolute; top: 27%; left: 20%;">Time played: <?php print secondsToTime($row["_TimePlayed"]); ?></p>
</div>
    <div id="bar" style="background-color: <?php print($infobarcolor); ?>; width: 100%; height: 7%; position: absolute; top: 90%;">
        
</div>

<?php
        }
    } else {
    ?>
    	<div id="profile" style="background-color: <?php print($infoboxcolor); ?>; width: 25em; height: 10em; position: relative;">
    <img class="avatar" style="position: absolute; top: 21%; left:2%; width: 4em" src="assets/img/unknown.jpg" />
    <div id="info">
        <p class="clan" style="color: white; position: absolute; top: 15%; left: 20%;">Steam64ID not found, you must be new here!</p>
		<p class="clan" style="color: white; position: absolute; top: 26%; left: 20%;">Good luck on the server!</p>
		<p class="clan" style="color: white; position: absolute; top: 37%; left: 20%;">I hope you will enjoy your first visit.</p>
        </div>
    <div id="bar" style="background-color: <?php print($infobarcolor); ?>; width: 100%; height: 7%; position: absolute; top: 90%;">
        </div>
<?php
}
    
    mysqli_close($conn);
	
?>
    </div>
    
           <div id="myProgress" style="top:57%;">
  <div id="myBar">
    <div id="label">0%</div>
  </div>
</div>
    </div>
   
	<script>
       

// @win window reference
// @fn function reference
function contentLoaded(win, fn) {

    var done = false, top = true,

    doc = win.document,
    root = doc.documentElement,
    modern = doc.addEventListener,

    add = modern ? 'addEventListener' : 'attachEvent',
    rem = modern ? 'removeEventListener' : 'detachEvent',
    pre = modern ? '' : 'on',

    init = function(e) {
        if (e.type == 'readystatechange' && doc.readyState != 'complete') return;
        (e.type == 'load' ? win : doc)[rem](pre + e.type, init, false);
        if (!done && (done = true)) fn.call(win, e.type || e);
    },

    poll = function() {
        try { root.doScroll('left'); } catch(e) { setTimeout(poll, 50); return; }
        init('poll');
    };

    if (doc.readyState == 'complete') fn.call(win, 'lazy');
    else {
        if (!modern && root.doScroll) {
            try { top = !win.frameElement; } catch(e) { }
            if (top) poll();
        }
        doc[add](pre + 'DOMContentLoaded', init, false);
        doc[add](pre + 'readystatechange', init, false);
        win[add](pre + 'load', init, false);
    }

}
   

  var audio = document.getElementById("audio");
  audio.volume = <?php print($songvol / 100); ?>;
        </script>

</body>
</html>