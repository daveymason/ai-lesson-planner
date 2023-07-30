    function submitForm() {
    document.getElementById("lesson-plan-output").innerHTML = "Loading...might take upto 30 seconds.";

    var language = document.getElementById("language").value;
    var coTeacherLanguage = document.getElementById("co-teacher-language").value;
    var curriculum = document.getElementById("curriculum").value;
    var subject = document.getElementById("subject").value;
    var topic = document.getElementById("topic").value;
    var activityduration = document.getElementById("activity-duration").value;
    var age = document.getElementById("age").value;
    var level = document.getElementById("level").value;
    var activitytype = document.getElementById("activity-type").value;
    var keywords = document.getElementById("keyswords").value;
    var location = document.getElementById("location").value;

    var prompt = `Generate a detailed lesson plan incorporating the following parameters:

    - Curriculum: ${curriculum}
    - Subject: ${subject}
    - Age Group: ${age}
    - Level: ${level}
    - Topic: ${topic}
    - Activity Type: ${activitytype}
    - Language: ${language}
    - Co-teacher Language: ${coTeacherLanguage}
    - Location: ${location}
    - Activity Duration: ${activityduration}
    - keywords: ${keywords}

    The lesson plan should adhere to the principles of the ${curriculum} curriculum and the Laws applied to the 
    location of ${location}. The lesson should be designed for students aged ${age} and at a ${level} level.
    The lesson will be for the subject of ${subject} specifically on the topic of ${topic}. 
    The main activity should involve '${activitytype}'.The activity should last ${activityduration} minutes. 
    The language of instruction will be ${language}. 
    Also, please provide a section with co-teacher instructions & vocabulary in ${coTeacherLanguage}.
    Co-Teacher Instructions section should be entirely in ${coTeacherLanguage} while the vocabulary section 
    should have both languages. 
    
    The lesson plan should be concise, no more than 500 words, and must contain the following sections: 
    Warm-up, Presentation, Practice, Production, and Co-teacher Instructions. 
    Also, please include a vocabulary, grammar, and phonics section relevant to the topic '${topic}'.
    Each section of the plan should clearly state the objective, 
    the activities planned to meet the objective, and the resources required for the activities.
    When creating the lesson plan, please incorporate the following keywords: ${keywords}.
    Please include the parameters of the lesson plan in the title of the lesson plan.`;
    

    function decodeUnicode(str) {
        var r = /\\u([\d\w]{4})/gi;
        str = str.replace(r, function (match, grp) {
            return String.fromCharCode(parseInt(grp, 16)); 
        } );
        return unescape(str); //this still works and I don't know why. 
    }
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lesson-plan-output").innerHTML = "";
            var response = decodeUnicode(this.responseText);
            document.getElementById("lesson-plan-output").innerHTML = response;
        }
    };
    xhttp.open("POST", ai_lesson_planner_data.ajaxurl, true); 
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=test_openai_api&prompt=" + encodeURIComponent(prompt));
    }

    function copyText() {
        var text = document.getElementById('lesson-plan-output').textContent;
        navigator.clipboard.writeText(text).then(function() {
            showToast("Copied to Clipboard, Go forth and teach!");
        }).catch(function() {
            showToast("Failed to copy text");
        });
    }
    
    function showToast(message) {
        var toast = document.getElementById("toast");
        toast.textContent = message;
        toast.style.visibility = "visible";
        toast.style.opacity = 1;
        setTimeout(function() { 
            toast.style.visibility = "hidden";
            toast.style.opacity = 0;
        }, 3000);
    }
    
    
    
    
    
