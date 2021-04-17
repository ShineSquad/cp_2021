<style type="text/css">
    #inst24 .p-3 {
        /*background-color: green;*/
    }
    .container {
        width: 100%;
        height: 100%;
    }
    header {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
        header .name-data {
            display: flex;
            flex-direction: row;
        }
            header .name-data .photo {
                border-radius: 3px;
            }
            header .name-data .naming {
                margin-left: 10px;
                height: 35px;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
            }
                header .name-data .naming .regalia {
                    font-size: 11px;
                    line-height: 13px;
                    color: #575757;
                }
                header .name-data .naming .name {
                    font-weight: bold;
                    font-size: 14px;
                    line-height: 16px;
                    color: #0F6FC5;
                }
        header .coins {
            font-size: 11px;
            line-height: 13px;
            color: #0F6FC5;
            width: 35px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    .satiety {
        margin: 14px 0;
        background: #EA8679;
        width: 153px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
        .satiety .text {
            font-size: 12px;
            line-height: 14px;
            color: #FFFFFF;
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
        $this->title = get_string('Mascot', 'block_mascot');
    }

    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        $this->content->text = "
            <div class='container'>
                <header>
                    <div class='name-data'>
                        <img src='https://im0-tub-ru.yandex.net/i?id=77f707ef6ad3b7225da9ce6e8ca68388&n=13&exp=1' width='35' height='35' class='photo'>
                        <div class='naming'>
                            <p class='regalia'>Ваш адъютант</p>
                            <p class='name'>Гриша</p>
                        </div>
                    </div>
                    <div class='coins'>
                        <p class='count'>1087</p>
                        <p class='text'>монет</p>
                    </div>
                </header>
                <div class='satiety'>
                    <p class='text'>Уровень сытости: <a id='satiety-value'>23%</a></p>
                </div>
            </div>";
        $this->content->footer = 'this is the footer';

        return $this->content;
    }
}
