"""
URL configuration for provinear_api project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path, include
from drf_spectacular.views import SpectacularAPIView, SpectacularSwaggerView, SpectacularRedocView

from provinear_api import root_view

urlpatterns = [
    path('provinear-admin/backend/', admin.site.urls),
    path('api-auth/', include('rest_framework.urls')),
    path('api/v1/', root_view.ApiRoot.as_view()),
    path("api/v1/schema/", view=SpectacularAPIView.as_view(), name="schema"),
    path("api/v1/schema/docs/", view=SpectacularSwaggerView.as_view(url_name="schema")),
    path('api/v1/schema/redoc/', SpectacularRedocView.as_view(url_name='schema'), name='redoc'),
    path('api/v1/waitlist/', include('waitlist.urls'), name='waitlist'),
    path('api/v1/provineer/', include('account.urls'), name='provineer')
]
