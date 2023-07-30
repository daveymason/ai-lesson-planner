# AI Lesson Planner

AI Lesson Planner is a WordPress plugin powered by OpenAI. It assists international educators in generating detailed lesson plans based on various user-defined parameters.

## Demo
To see a full demo of the AI Lesson Planner, visit https://kindersync.com/ai-lesson-planner

## Prerequisites

- You need to have a WordPress website to use this plugin.
- You need to have your OpenAI key.

## Installation

1. Download the AI Lesson Planner zip file.
2. Log in to your WordPress site.
3. Navigate to the **Plugins** section, then click on **Add New**.
4. Click **Upload Plugin**, and choose the AI Lesson Planner zip file you downloaded earlier.
5. Click **Install Now** to install the plugin.
6. After installation, click **Activate Plugin** to start using AI Lesson Planner.

## Configuration

To add your OpenAI key:

1. Navigate to the folder where the plugin is installed (typically `wp-content/plugins/ai-lesson-planner/`).
2. Open the `ai-lesson-planner.php` file.
3. In `ai-lesson-planner.php`, find the line that contains `define('OPENAI_API_KEY', 'sk--YOUR-CODE-HERE');`.
4. Replace `'sk--YOUR-CODE-HERE'` with your actual OpenAI key (it should look like `'sk--abcdef123456'`).

Please note, for security reasons, it's important not to expose your OpenAI API key in your source code if it's publicly accessible. Instead, consider loading it from an environment variable or a secure file that's not included in your version control system.

## How it Works

The application takes the parameters entered by the user and formulates a prompt. This prompt is then passed to the OpenAI GPT-3.5-turbo model, which generates a text based on the input. The generated text (the lesson plan) is then displayed on the webpage.

The application uses AJAX to send a POST request to the server and then fetch the response. The URL and other required data for this request are stored in the 'ai_lesson_planner_data' JavaScript object, which is localized from the server-side.

Once the response from the model is received, any Unicode characters in the response are decoded using the decodeUnicode function in JavaScript for proper display. The lesson plan is then displayed on the webpage within the "lesson-plan-output" HTML element.

JavaScript is also used for handling Unicode characters in the response, copying the lesson plan text to the clipboard, and showing a 'toast' message when the text has been successfully (or unsuccessfully) copied.

## Usage

Upon opening the application, you will find a form to input the parameters for your lesson plan. These parameters include:

Language: The language of instruction for the lesson plan.
Co-teacher Language: The language to be used in the co-teacher instructions & vocabulary section.
Curriculum: The curriculum to adhere to for the lesson plan.
Subject: The subject of the lesson.
Topic: The specific topic for the lesson.
Activity Duration: The duration (in minutes) for the main activity in the lesson.
Age Group: The age group of the students for whom the lesson is designed.
Level: The level of comprehension of the students (e.g. beginner, intermediate, advanced).
Activity Type: The type of activity involved in the lesson.
Keywords: The keywords to be incorporated into the lesson plan.
Location: The location where the lesson will be taught, as it might affect the laws and regulations adhered to in the lesson.
After inputting the parameters, click the 'Generate Lesson Plan' button. The application will take a few seconds to generate your lesson plan and display it in the 'Lesson Plan' section.

There's also a 'Copy to Clipboard' button that you can use to copy the entire text of the generated lesson plan.

## Licence

This project is licensed under the GNU GENERAL PUBLIC LICENSE Version 3.

- You are free to use, modify, and distribute this tool. You can make minor tweaks to the prompt, add a new face, or integrate it anywhere you can find a use for it. Feel free to rip it apart and put it back together.

- However, please refrain from adding a paywall to it. The developer believes that technology can minimize the barriers to high-quality education for everyone, so join the team and Keep up the good work; keep it open source & keep it free.