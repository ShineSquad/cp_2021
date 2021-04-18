<style type="text/css">
    #mas-container {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #mascot {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 600px;
        width: 320px;
        position: relative;
        background-image: url(https://shsq.ru/moodle/user-images/forest2.png);
        background-size: 110% 110%;
        background-position: 50% 50%;
        overflow: hidden;
    }
    #mascot img {
        width: 300px;
    }
    #mascot #mas-controls {
        position: absolute;
        bottom: 20px;
        display: flex;
        flex-direction: row;
    }
    #mascot #mas-controls .btn {
        color: white;
        padding: 10px;
        margin: 0px 3px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        position: relative;
    }
        #mascot #mas-controls .btn.foods {background: #46B2CA;}
        #mascot #mas-controls .btn.games {background: #EA8679;}
        #mascot #mas-controls .btn.home {background: #47D780;}
    #mascot #mas-controls .btn a {
        color: white;
        text-decoration: none;
    }

    #mascot #mas-popup {
        position: absolute;
        width: 140px;
        height: 50px;
        top: 150px;
        left: 15px;
        background: white;
        border-radius: 3px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        font-size: 12px;
        transition: 1s;
        cursor: pointer;
        user-select: none;
    }
        #mascot #mas-popup:before {
            content: "";
            position: absolute;
            top: 50px;
            height: 0px;
            width: 0px;
            border: solid 10px;
            border-color: white white transparent transparent;
            right: 8px;
        }

    .bages:after {
        content: attr(count);
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 100px;
        background-color: red;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 10px;
        top: -9px;
        right: -4px;
        z-index: 2;
    }

    .shake {
        animation: shake .2s infinite linear reverse;
    }
        @keyframes shake{
            from { transform: translateX(-1px); }
            to { transform: translateX(1px); }
        }
</style>
<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Newblock block caps.
 *
 * @package    block_mascot
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_mascot extends block_base {

    function init() {
        // $this->title = get_string('title', 'block_mascot');
        $this->title = "Талисман";
        // $DB->set_field($table, $newfield, $newvalue, array $conditions=null)
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        $this->setGames(50);

        $stats = $DB->get_record("mascot", ["user_id" => $USER->id]);

        $foods = $stats->foods;
        $games = $stats->games;

        $this->content->text .= "
            <div id='mas-container'>
                <div id='mascot'>
                    <div id='mas-popup' style='display: none; opacity: 0;' type='others'></div>
                    <img src='https://shsq.ru/moodle/user-images/pers1.png'>
                    <div id='mas-controls'>
                        <div class='btn foods bages' count='$foods'>Покормить</div>
                        <div class='btn games bages' count='$games'>Поиграть</div>
                        <div class='btn home'>
                            <a href='https://shinesquad.ru/projects/mascot/'
                               target='_blank' >
                                В комнату
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        ";

        return $this->content;
    }

    function setFoods($inc) {
        global $USER, $DB;

        $stats = $DB->get_record("mascot", ["user_id" => $USER->id]);
        $foods = $stats->foods;
        $DB->set_field("mascot", "foods", $foods+$inc, ["user_id" => $USER->id]);
    }

    function setGames($inc) {
        global $USER, $DB;

        $stats = $DB->get_record("mascot", ["user_id" => $USER->id]);
        $games = $stats->games;
        $DB->set_field("mascot", "games", $games+$inc, ["user_id" => $USER->id]);
    }
}
?>
<script type="text/javascript">
    const min_delay = 2000;
    const max_delay = 3000;
    const shake_duration = 300;
    const messages = {
        "games": [
            "Мне скучно", 
            "Поиграй со мной", 
            "Время играть!", 
            "Мячик?"
        ],
        "foods": [
            "Хочу кушать", 
            "Время перекусить", 
            "Кууушать!!!!", 
            "Пора кушать", 
            "Я голоден"
        ]
    };
    const sarcasm = [
        "sarcasm",
        "сарказм",
        "@!#?@!",
        "F"
    ];

    function _feed() {
        // TODO:
        // update data on databse
        console.log("_feed");

        var node = document.querySelector("#mas-controls .foods"),
            count = parseInt(node.getAttribute("count"));

        if (count == 0) {
            node.classList.toggle("shake");
            sadPP();
            setTimeout(()=>{node.classList.toggle("shake")}, shake_duration);
        } else {
            hidePP();
        }

        node.setAttribute("count", (count-1 <= 0) ? 0 : count-1);
    }
    function _play() {
        // TODO:
        // update data on databse
        console.log("_play");

        var node = document.querySelector("#mas-controls .games"),
            count = parseInt(node.getAttribute("count"));

        if (count == 0) {
            node.classList.toggle("shake");
            sadPP();
            setTimeout(()=>{node.classList.toggle("shake")}, shake_duration);
        } else {
            hidePP();
        }

        node.setAttribute("count", (count-1 <= 0) ? 0 : count-1);
    }

    function sadPP() {
        setPPmsg(sarcasm[getRnd(0,sarcasm.length)])
        setTimeout(hidePP, 1000);
    }

    function showPP(text="42", type="others") {
        var popup = document.querySelector("#mas-popup");

        popup.innerText = text;
        popup.style.display = "flex";
        popup.setAttribute("type", type);

        setTimeout(()=>{ popup.style.opacity = 1; }, 10)
    }

    function hidePP() {
        var popup = document.querySelector("#mas-popup");

        popup.style.opacity = 0;

        setTimeout(()=>{ popup.style.display = "none"; }, 500)
    }

    function getRnd(min, max) { return parseInt(Math.random()*max + min); }

    function PPmsg() {
        let key = Object.keys(messages)[getRnd(0,Object.keys(messages).length)];

        return {
            text: messages[key][getRnd(0,messages[key].length)],
            type: key
        }
    }

    function setPPmsg(text) {
        var popup = document.querySelector("#mas-popup");
        popup.innerText = text;
    }

    function PPtype() {
        return document.querySelector("#mas-popup").getAttribute("type");
    }

    function newMsg() {
        let msg = PPmsg();
        setTimeout(showPP, getRnd(min_delay,max_delay), msg.text, msg.type);
    }

    function bindActions() {
        let controls = document.querySelectorAll("#mas-controls .btn");
        for (node of controls) {
            node.addEventListener("click", (ev)=>{
                let cl = event.target.classList;
                if ( cl.contains(PPtype()) ) {
                    if (PPtype() == "games") { _play(); }
                    else { _feed() };

                    newMsg(); // DEL
                }
            })
        }

        let popup = document.querySelector("#mas-popup");

        popup.addEventListener("click", (ev)=>{
            sadPP();
            newMsg(); // DEL
        })
    }

    window.addEventListener("load", (ev)=>{
        bindActions();
        newMsg(); // DEL
    })
</script>