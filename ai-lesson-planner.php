<?php
/*
Plugin Name: AI Lesson Planner
Plugin URI: https://kindersync.com/
Description: A plugin to generate lesson plans using AI. Proudly built as part of the OMS CS6460 Educational Technology course at Georgia Tech.
Version: 1.0
Author: Davey Mason
Author URI: https://daveymason.com/
*/

define('OPENAI_API_KEY', 'sk-'); 

function ai_lesson_planner_enqueue_scripts() {
    wp_enqueue_script('ai-lesson-planner-script', plugin_dir_url( __FILE__ ) . 'ai-lesson-planner.js', array('jquery'), '1.0.0', true);

    wp_enqueue_style('ai-lesson-planner-style', plugin_dir_url( __FILE__ ) . 'ai-lesson-planner.css', array(), '1.0.0');

    $ai_lesson_planner_data = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    );
    wp_localize_script('ai-lesson-planner-script', 'ai_lesson_planner_data', $ai_lesson_planner_data);
}
add_action('wp_enqueue_scripts', 'ai_lesson_planner_enqueue_scripts');

function test_openai_api() {
	error_log(print_r($_POST, true));

	$prompt = $_POST['prompt'];


    $url = 'https://api.openai.com/v1/chat/completions';
    $body = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a helpful assistant.'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ],
        'max_tokens' => 1000,
    ];
    $headers = [
        'Authorization' => 'Bearer ' . OPENAI_API_KEY,
        'Content-Type' => 'application/json'
    ];
    $response = wp_remote_post($url, [
        'method' => 'POST',
        'headers' => $headers,
        'body' => json_encode($body),
        'timeout' => 100 // Set the timeout to 60 seconds or more
    ]);
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("OpenAI API error: $error_message");
        return "Something went wrong: $error_message";
    } else {
		$echo = wp_remote_retrieve_body($response);
		error_log(print_r($echo, true));

        $response_body = json_decode(wp_remote_retrieve_body($response), true);
        if (!isset($response_body['choices'][0]['message']['content'])) {
            error_log("Unexpected API response: " . print_r($response_body, true));
            error_log("Full API response: " . print_r($response, true));
            return "Unexpected API response.";
        }

		$response_content = $response_body['choices'][0]['message']['content'];
		$formatted_response_content = str_replace(["\\n", '\u'], '', $response_content);
		$formatted_response_content_br = str_replace("\n", "<br>", $formatted_response_content);

		$formatted_response_content_br = '<div class="lesson-plan">' . nl2br($formatted_response_content_br) . '</div>';
		wp_send_json($formatted_response_content_br);
    }
}
add_action('wp_ajax_test_openai_api', 'test_openai_api');
add_action('wp_ajax_nopriv_test_openai_api', 'test_openai_api');

function lesson_planner_form() {
    ob_start(); 

    ?>
    <form id="ai-lesson-planner-form" class="ai-lesson-planner-form">
        <div class="form-row">
            <div class="form-col">
                <label for="language">Language:</label>
                <select id="language" name="language" class="form-select">
                    <option value="english">English</option>
                    <option value="chinese">中文</option>
                </select>
            </div>
            <div class="form-col">
                <label for="co-teacher-language">Co-teacher Language:</label>

                <select id="co-teacher-language" name="co-teacher-language" class="form-select">
                    <option value="chinese">中文</option>
                    <option value="english">English</option>
                    <option value="japanese">日本語</option>
                    <option value="korean">한국어</option>
                    <option value="vietnamese">Tiếng Việt</option>
                    <option value="arabic">العربية</option>
                    <option value="hindi">हिन्दी</option>
                    <option value="french">Français</option>
                    <option value="german">Deutsch</option>
                    <option value="spanish">Español</option>
                    <option value="dutch">Nederlands</option>
                    <option value="flemish">Vlaams</option>
                    <option value="irish">Gaeilge</option>
                    <option value="serbian">Srpski</option>
                    <option value="albanian">Shqip</option>
                    <option value="armenian">Հայերեն</option>
                    <option value="yoruba">Yorùbá</option>
                    <option value="afar">Afaraf</option>
                    <option value="Amharic">አማርኛ</option>
                    <option value="Oromo">Oromoo</option>
                    <option value="Somali">Soomaaliga</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="curriculum">Curriculum:</label>
                <select id="curriculum" name="curriculum" class="form-select">
                    <option value="tefl">TEFL</option>
                    <option value="international-baccalaureate">International Baccalaureate </option>
                    <option value="advanced-placement">Advanced Placement</option>
                </select>
            </div>
            <div class="form-col">
                <label for="subject">Subject:</label>
                <select id="subject" name="subject" class="form-select">
                    <option value="english">English</option>
                    <option value="math">Math</option>
                    <option value="science">Science</option>
                    <option value="history">History</option>
                    <option value="art">Art</option>
                    <option value="music">Music</option>
                    <option value="physical-education">Physical Education</option>
                    <option value="computer-science">Computer Science</option>
                </select>
            </div>

        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="age">Age:</label>
                <select id="age" name="age" class="form-select">
                    <option value="3-5">3-5 years</option>
                    <option value="6-8">6-8 years</option>
                    <option value="9-12">9-12 years</option>
                    <option value="13-15">13-15 years</option>
                    <option value="16-18">16-18 years</option>
                </select>
            </div>
            <div class="form-col">
                <label for="level">Level:</label>
                <select id="level" name="level" class="form-select">
                    <option value="basic">Basic</option>
                    <option value="standard">Standard</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="activity-type">Activity Type:</label>
                <select id="activity-type" name="activity-type" class="form-select">
                    <option value="group-work">Group Work</option>
                    <option value="individual-task">Individual Task</option>
                    <option value="role-playing">Role-playing</option>
                    <option value="hands-on">Hands-on Activity</option>
                    <option value="discussion">Discussion</option>
                    <option value="presentation">Presentation</option>
                    <option value="game">Game</option>
                    <option value="quiz">Quiz</option>
                    <option value="test">Test</option>
                    <option value="homework">Homework</option>
                    <option value="project">Project</option>
                    <option value="reading">Reading</option>
                    <option value="writing">Writing</option>
                    <option value="listening">Listening</option>
                    <option value="speaking">Speaking</option>
                    <option value="grammar">Grammar</option>
                    <option value="vocabulary">Vocabulary</option>
                    <option value="pronunciation">Pronunciation</option>
                    <option value="phonics">Phonics</option>
                    <option value="spelling">Spelling</option>
                </select>
            </div>

            <div class="form-col">
                <label for="activity-duration">Activity Duration:</label>
                <select id="activity-duration" name="activity-duration" class="form-select">
                    <option value="30">30 Minutes</option>
                    <option value="40">40 Minutes</option>
                    <option value="50">50 Minutes</option>
                    <option value="60">60 Minutes</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <label for="topic">Topic:</label>
                <input type="text" id="topic" name="topic" class="form-control" placeholder="Choose a topic">
            </div>

            <div class="form-col">
                <label for="keyswords">Keywords:</label>
                <input type="text" id="keyswords" name="keyswords" class="form-control" placeholder="Word to include">
            </div>

            <div class="form-col">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="China">
            </div>
        </div>

        <button type="button" id="generate-button" onclick="submitForm()" class="generate-button">Generate</button>
    </form>
    <div id="toast"></div>
    <button id="copyButton" onclick="copyText()">
        <i class="fa-solid fa-copy"></i>
    </button>
    <div id="lesson-plan-output" class="lesson-plan-output">
    </div>
    <?php

    return ob_get_clean(); 
    }

    function lesson_planner_shortcode() {
        return lesson_planner_form();
    }
    add_shortcode('lesson_planner', 'lesson_planner_shortcode');
    ?>