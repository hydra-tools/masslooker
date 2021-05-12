<?php
require('lib/config.php');
$cookieData		= explode('|', file_get_contents('./data/'.$cookieFile));
$cookie 		= $cookieData[0]; // Cookie Instagram
$useragent 		= $cookieData[1]; // Useragent Instagram
$loop			= true;
//feed/user/{$userId}/story/
echo "
 ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        +2DzdfNg83XDYPN2C2Dzdgg +2Dzde9g83X7YPN1+2Dzdetg83XTYPN2B 
	$---------$--------$
	1.Mass story views without Action block
	2.Reacts to stories
	3.Auto Poll reactions
	4.Auto Question Ansewring
	$---------$--------$
	
	+AFw-n";
echo "[o] $$$$$$$$$$ Auto  Story Viewer by Rahul $$$$$$$$$$$$$$$$$$ [o]+AFw-n";
echo "  $----$----$ Author nthanfp Modified by +2D7dEQ @hydra-tech +2D7dEQ $----$---$   +AFw-n+AFw-n";

 +AFw-n+AFw-n";

if($cookie){
	$getakun	= proccess(1, $useragent, 'accounts/current_user/', $cookie);
	$getakun	= json_decode($getakun[1], true);
	if($getakun['status'] == 'ok'){
		//LOSS
		$getakunV2	= proccess(1, $useragent, 'users/'.$getakun['user']['pk'].'/info', $cookie);
		$getakunV2	= json_decode($getakunV2[1], true);
		echo "[+AH4] Login as @".$getakun['user']['username']." +AFw-n";
		echo "[+AH4] [Media : ".$getakunV2['user']['media_count']."] [Follower : ".$getakunV2['user']['follower_count']."] [Following : ".$getakunV2['user']['following_count']."]+AFw-n";
		echo "[+AH4] Please wait 5 second for loading script+AFw-n";
		echo "[+AH4] "; for($x = 0; $x <= 4; $x+-+-){ echo "========"; sleep(1); } echo "+AFw-n+AFw-n";
		do {
			$targets	= file_get_contents('./data/'.$targetFile);
			$targets 	= explode("+AFw-n", str_replace("+AFw-r", "", $targets));
			$targets 	= array($targets)[0];
			foreach($targets as $target){
				$komens		= file_get_contents('./data/'.$answerFile);
				$komen		= explode("+AFw-n", str_replace("+AFw-r", "", $komens));
				$komen		= array($komen)[0];
				//
				$todays		= file_get_contents('./data/daily/'.date('d-m-Y').'.txt');
				$today		= explode("+AFw-n", str_replace("+AFw-r", "", $todays));
				$today		= array($today)[0];
				//
				//$proxy		= file_get_contents('https://veonpanel.com/api/panel/proxy?key=MEMEF');
				//$proxy		= json_decode($proxy, true);
				//$prox['ip']			= $proxy['data']['proxy'];
				$prox['ip']			= 0;
				$prox['user']		= 0;
				$prox['is_socks5']	= 0;
				//
				echo "[+AH4] Get followers of ".$target."+AFw-n";
				//echo "[+AH4] Proxy ".$prox['ip']."+AFw-n";
				$targetid	= json_decode(request(1, $useragent, 'users/'.$target.'/usernameinfo/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5'])[1], 1)['user']['pk'];
				$gettarget	= proccess(1, $useragent, 'users/'.$targetid.'/info', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
				$gettarget	= json_decode($gettarget[1], true);
				echo "[+AH4] [Media : ".$gettarget['user']['media_count']."] [Follower : ".$gettarget['user']['follower_count']."] [Following : ".$gettarget['user']['following_count']."]+AFw-n";
				$jumlah		= $countTarget;
				if(!is_numeric($jumlah)){
					$limit = 1;
				} elseif ($jumlah > ($gettarget['user']['follower_count'] - 1)){
					$limit = $gettarget['user']['follower_count'] - 1;
				} else {
					$limit = $jumlah - 1;
				}
				$next      	= false;
				$next_id    = 0;
				$listids	= array();
				do {
					if($next == true){ $parameters = '?max_id='.$next_id.''; } else { $parameters = ''; }
					$req        = proccess(1, $useragent, 'friendships/'.$targetid.'/followers/'.$parameters, $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
					$req        = json_decode($req[1], true);
					if($req['status'] !== 'ok'){
						var_dump($req);
						exit();
					}
					for($i = 0; $i < count($req['users']); $i+-+-):
						if($req['users'][$i]['is_private'] == false):
							if($req['users'][$i]['latest_reel_media']):
								if(count($listids) <= $limit):
									$listids[count($listids)] = $req['users'][$i]['pk'];
								endif;
							endif;
						endif;
					endfor;
					if($req['next_max_id']){ $next = true; $next_id	= $req['next_max_id']; } else { $next = false; $next_id = '0'; }
				} while(count($listids) <= $limit);
				echo "[+AH4] ".count($listids)." followers of ".$target." collected+AFw-n";
				$reels		= array();
				$reels_suc	= array();
				for($i = 0; $i < count($listids); $i+-+-):
					$getstory   = proccess(1, $useragent, 'feed/user/'.$listids[$i].'/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
					$getstory   = json_decode($getstory[1], true);
					foreach($getstory['reel']['items'] as $storyitem):
						$reels[count($reels)]	= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['id']			= $storyitem['id'];
						$stories['reels']		= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['reel']		= $storyitem['taken_at'].'_'.time();
						if(strpos(file_get_contents('./data/storyData.txt'), $stories['reels']) == false){
							$hook       = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"'.$stories['reels'].'": ["'.$stories['reel'].'"]}, "live_vods": {}, "reel_media_skipped": {}}';
							$viewstory  = proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook(''.$hook.''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
							$viewstory  = json_decode($viewstory[1], true);
							if($storyitem['story_polls']){
								$stories['pool_id']	= $storyitem['story_polls'][0]['poll_sticker']['poll_id'];
								$react_1	  		= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['pool_id'].'/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "'.rand(0,1).'"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_1			= json_decode($react_1[1], true);
								if($react_1['status'] == 'ok'){
									echo "[+AH4] ".date('d-m-Y H:i:s')." - Success polling for ".$stories['id']."+AFw-n";
								}
								//echo "[Stories Polls True : ".$stories['pool_id']." : ".$react_1[1]."] ";
							}
							if($storyitem['story_questions']){
								$stories['question_id']	= $storyitem['story_questions'][0]['question_sticker']['question_id'];
								$rand					= rand(0, count($komen)-1);
						        $textAnswer 			= $komen[$rand];
								$react_2	  			= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['question_id'].'/story_question_response/', $cookie, hook('{"response": "'.$textAnswer.'", "type": "text"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_2				= json_decode($react_2[1], true);
								if($react_2['status'] == 'ok'){
									echo "[+AH4] ".date('d-m-Y H:i:s')." - Question answer for ".$stories['id']." : ".$textAnswer." +AFw-n";
								}
								//echo "[Stories Question True : ".$stories['question_id']." : ".$react_2[1]."] ";
							}
							if($storyitem['story_countdowns']){
								$stories['countdown_id']	= $storyitem['story_countdowns'][0]['countdown_sticker']['countdown_id'];
								$react_3	  				= proccess(1, $useragent, 'media/'.$stories['countdown_id'].'/follow_story_countdown/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_3					= json_decode($react_3[1], true);
								//echo "[Stories Countdown True : ".$stories['countdown_id']." : ".$react_3[1]."] ";
							}
							if($storyitem['story_sliders']){
								$stories['slider_id']	= $storyitem['story_sliders'][0]['slider_sticker']['slider_id'];
								$react_4	  			= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['slider_id'].'/story_slider_vote/', $cookie, hook('{"radio_type": "wifi-none", "vote": "1"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_4				= json_decode($react_4[1], true);
								if($react_2['status'] == 'ok'){
									echo "[+AH4] ".date('d-m-Y H:i:s')." - Success sent slider for ".$stories['id']."+AFw-n";
								}
								//echo "[Stories Slider True : ".$stories['slider_id']." : ".$react_4[1]."] ";
							}
							if($storyitem['story_quizs']){
								$stories['quiz_id']	= $storyitem['story_quizs'][0]['quiz_sticker']['quiz_id'];
								//$react_5	  		= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['quiz_id'].'/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "'.rand(0,3).'"}'));
								//echo "[Stories Quiz True : ".$stories['quiz_id']." : ".$react_5[1]."] ";
							}
							if($viewstory['status'] == 'ok'){
								$reels_suc[count($reels_suc)] = $storyitem['id']."_".$getstory['reel']['user']['pk'];
								echo "[+AH4] ".date('d-m-Y H:i:s')." - Seen stories ".$stories['id']." +AFw-n";
								saveData('./data/storyData.txt', $stories['reels']);
								saveData('./data/daily/'.date('d-m-Y').'.txt', $stories['reels']);
							}
							sleep($sleep_1);
						}
					endforeach;
					echo "[+AH4] ".date('d-m-Y H:i:s')." - Sleep for ".$sleep_2." second to bypass instagram limit+AFw-n"; sleep($sleep_2);
				endfor;
				echo "[+AH4] ".count($reels)." story from ".$target." collected+AFw-n";
				echo "[+AH4] ".count($reels_suc)." story from ".$target." marked as seen+AFw-n";
				echo "[+AH4] ".count($today)." story reacted today+AFw-n";
				echo "[+AH4] ".date('d-m-Y H:i:s')." - Sleep for 30 second to bypass instagram limit+AFw-n";
				echo "[+AH4] "; for($x = 0; $x <= 4; $x+-+-){ echo "========"; sleep(6); } echo "+AFw-n+AFw-n";
			}
			if(count($today) > '1900'){
				echo "[+AH4] ".count($today)." story reacted today+AFw-n";
				echo "[+AH4] Limit instagram api 2000 seen/day+AFw-n";
				echo "[+AH4] Sleep for 20 hours to bypass instagram limit+AFw-n";
				sleep(72000);
				echo "[+AH4] End sleep...+AFw-n+AFw-n";
			}
		} while($loop == true);
	} else {
		echo "[!] Error : ".json_encode($getakun)."+AFw-n";
	}
} else {
	echo "[!] Please login+AFw-n";
}
?>