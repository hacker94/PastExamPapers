# from django.shortcuts import render_to_response
from django.template import Context
from django.shortcuts import render_to_response

import os
from papergen import getTabs

APP_DIR = os.path.dirname(__file__)

def index(request) :
    return render_to_response('index.html', Context({'tabs' : getTabs()}))
