"""Copyright c.2024 Provinear@Dynamo

This module contains the model definition for Provinear's wait list

Author: Warith Adetayo
Date created: March 13, 2024
"""

from django.core.validators import EmailValidator
from django.db import models
from django.utils.translation import gettext_lazy as _


class WaitList(models.Model):
    """A model representing Provinear's users (buyers) wait list

    Attributes:
        email (str): The email address of the user joining the wait list
        full_name (str): The full name of the user joining the wait list
        interested_in_buying (bool): Whether the user is interested in buying on Provinear
        interested_in_selling (bool): Whether the user is interested in selling on Provinear
        receive_updates (bool): Whether the user is interested in receiving updates and notification on Provinear
    """

    email = models.EmailField(
        verbose_name=_('Email'),
        primary_key=True,
        help_text=_('Enter your email address'),
        validators=[EmailValidator(message="Enter a valid email address")]
    )
    full_name = models.CharField(
        verbose_name=_('Full name'),
        help_text=_('Enter your full name'),
        max_length=128,
        blank=False,
        null=False
    )
    interested_in_buying = models.BooleanField(
        verbose_name='Interested in Buying',
        help_text='Are you interested in buying on Provinear?',
        blank=False,
        null=False
    )
    interested_in_selling = models.BooleanField(
        verbose_name='Interested in Selling',
        help_text='Are you interested in selling on Provinear?',
        blank=False,
        null=False
    )
    receive_updates = models.BooleanField(
        verbose_name='Receive updates',
        help_text='Receive updates and notification from Provinear?',
        blank=True,
        null=False,
        default=False
    )
    date_created = models.DateTimeField(
        verbose_name=_('Date Joined'),
        auto_now_add=True,
        blank=True,
        null=False,
    )

    class Meta:
        db_table = 'waitlist'
        verbose_name = 'Wait List'
        verbose_name_plural = 'Wait Lists'

    def __str__(self):
        return f"WaitList<email='{self.email}', name='{self.full_name}'>"
