"""Copyright c.2024 Provinear@Dynamo

This module contains the view definitions for WaitList Model

Author: Warith Adetayo
Date created: March 13, 2024
"""

from drf_spectacular.utils import extend_schema_view, extend_schema
from rest_framework.generics import CreateAPIView

from waitlist.serializers import WaitListSerializer


@extend_schema_view(
    post=extend_schema(description='Join waiting list', summary='Add user to waiting list',
                       tags=['Wait List'])
)
class JoinWaitListView(CreateAPIView):
    serializer_class = WaitListSerializer
