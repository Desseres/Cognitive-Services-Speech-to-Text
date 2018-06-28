# Cognitive Services: Speech to Text

Proof of concept created on Neuca DevDay Q3-2018 Event. 
Project showing the possibility of using [Cognitive Service: Speech to Text](https://docs.microsoft.com/en-us/azure/cognitive-services/speech-service/) in PHP.
I have created a simple website that allows speech to be translated into text.
[The Lumen Framework](https://lumen.laravel.com/docs/5.6) was used for the implementation of the project.

![App Screen](https://kasztelan.me/wp-content/uploads/2018/06/example.png)

# Stages of the project

* creation development environment
* read the [documentation](https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/getstarted/getstartedrest?tabs=Powershell)
* obtaining [API Key](https://docs.microsoft.com/en-us/azure/cognitive-services/speech-service/get-started)
* read the examples in [other languages](https://docs.microsoft.com/en-us/azure/cognitive-services/speech-service/quickstart-csharp-windows)
* creating a class in php

# Requirements

* PHP >= 7.1.3
* Lumen 5.6.*
* PHP cURL extension

# Installation

```bash
cp .env.example .env
composer install
```

# How it works

![How it works](https://kasztelan.me/wp-content/uploads/2018/06/Process.png)

# External libraries

* [Audio Recorder](https://webaudiodemos.appspot.com/AudioRecorder/index.html)
* [mattdiamond/Recorderjs](https://github.com/mattdiamond/Recorderjs)