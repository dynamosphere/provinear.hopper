from django.contrib.auth import get_user_model
from django.contrib.auth.password_validation import validate_password
from rest_framework import serializers

from appdata.models.ModelProvineer import Provineer


class ProvineerSerializer(serializers.ModelSerializer):
    class Meta:
        model = Provineer
        fields = '__all__'

        extra_kwargs = {
            'password': {
                'write_only': True,
                'style': {'input_type': 'password'},
                'trim_whitespace': False,
                'validators': [validate_password]
            }
        }

    def create(self, validated_data):
        """Create a new User with encrypted password"""

        return get_user_model().objects.create_user(**validated_data)
