from collections import OrderedDict

from django.apps import apps
from django.urls import include, NoReverseMatch
from rest_framework.reverse import reverse


def get_app_named_urls(app_url, request, name_filter=None, format=None):

    named_urls = OrderedDict()

    for url_pattern in include(app_url)[0].urlpatterns:
        if (name_filter and name_filter(url_pattern.name)) or name_filter is None:
            named_urls[url_pattern.name] = reverse(url_pattern.name, request=request, format=format)

    return named_urls
