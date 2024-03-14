"""Copyright c.2024 Provinear@Dynamo

This module contains the url path definitions for WaitList views

Author: Warith Adetayo
Date created: March 13, 2024
"""

from django.urls import path

from waitlist import views

urlpatterns = [
    path('', views.JoinWaitListView.as_view(), name='join-wait-list')
]
