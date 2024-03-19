"""Copyright c.2024 Provinear@Dynamo

The module contains utility functions to work on django urls

Author: Warith Adetayo
Date created: March 13, 2024
"""

from collections import OrderedDict

from django.urls import include
from rest_framework.reverse import reverse


def get_app_named_urls(app_url, request, name_filter=None, format=None):
    """ Returns the dict of the url routes mapped to their name present in a django app
    Args:
        app_url (str): The django app url path
        request (Request): Django Request object
        name_filter (lambda): A function to filter the url routes (Takes a single parameter and returns a boolean value)
        format (str): Format of the reversed url]
    """

    named_urls = OrderedDict()

    for url_pattern in include(app_url)[0].urlpatterns:
        if (name_filter and name_filter(url_pattern.name)) or name_filter is None:
            named_urls[url_pattern.name] = reverse(url_pattern.name, request=request, format=format)

    return named_urls
