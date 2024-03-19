from django.urls import path

from account.views import JoinProvinearView

urlpatterns = [
    path("", JoinProvinearView.as_view(), name="join-provinear")
]
