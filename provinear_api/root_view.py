from drf_spectacular.utils import extend_schema
from rest_framework import viewsets
from rest_framework.response import Response
from rest_framework.views import APIView

from shared.utils.urls import get_app_named_urls


class ApiRoot(APIView):

    @extend_schema(exclude=True)
    def get(self, request, format=None):
        return Response(
            {
                "waitlist": get_app_named_urls('waitlist.urls', request, format=format),
            }
        )
