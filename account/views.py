from django.contrib.auth import login, authenticate
from django.contrib.auth.backends import BaseBackend
from drf_spectacular.utils import extend_schema_view, extend_schema
from rest_framework.authentication import TokenAuthentication, BasicAuthentication
from rest_framework.generics import CreateAPIView

from account.serializers import ProvineerSerializer


# Create your views here.


@extend_schema_view(
    post=extend_schema(description='Join Provinear', summary='Create a new user account (Provineer)',
                       tags=['Provineer (User Account Management)'])
)
class JoinProvinearView(CreateAPIView):
    serializer_class = ProvineerSerializer
    authentication_classes = (TokenAuthentication, BasicAuthentication, BaseBackend)
    login
    authenticate
