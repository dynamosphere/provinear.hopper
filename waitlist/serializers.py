"""Copyright c.2024 Provinear@Dynamo

This module contains the serializer definition for model WaitList

Author: Warith Adetayo
Date created: March 13, 2024
"""

from rest_framework import serializers

from waitlist import models


class WaitListSerializer(serializers.ModelSerializer):
    """Model Serializer for WaitList Model"""

    class Meta:
        model = models.WaitList
        fields = '__all__'
