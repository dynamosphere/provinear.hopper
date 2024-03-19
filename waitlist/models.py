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
        expectation (str): Users can optionally give their expectation from joining Provinear
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
    expectation = models.TextField(
        verbose_name=_('Expectation'),
        help_text=_('What is your expectation from joining Provinear?'),
        blank=True,
        null=True
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
