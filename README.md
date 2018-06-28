# Cognitive Services: Speech to Text

Proof of concept created on Neuca DevDay Q3-2018 Event. 
Project showing the possibility of using [Cognitive Service: Speech to Text](https://docs.microsoft.com/en-us/azure/cognitive-services/speech-service/) in PHP.
I have created a simple website that allows speech to be translated into text.
[The Lumen Framework](https://lumen.laravel.com/docs/5.6) was used for the implementation of the project.

![example](https://user-images.githubusercontent.com/4050097/42022154-bd38dbee-7abc-11e8-974a-6fbdce48c18a.png)

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

![process](https://user-images.githubusercontent.com/4050097/42022132-ae22d72c-7abc-11e8-82f8-dc0c98cc9e14.png)

# External libraries

* [Audio Recorder](https://webaudiodemos.appspot.com/AudioRecorder/index.html)
* [mattdiamond/Recorderjs](https://github.com/mattdiamond/Recorderjs)
