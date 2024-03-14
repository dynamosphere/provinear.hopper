"""Copyright c.2024 Provinear@Dynamo

This module contains the model definition for Provinear's wait list

Author: Warith Adetayo
Date created: March 13, 2024
"""

from django.core.validators import EmailValidator
from django.db import models


class WaitList(models.Model):
    """A model representing Provinear's users (buyers) wait list

    Attributes:
        email (str): The email address of the user joining the wait list
        name (str): The name of the user joining the wait list
        expectation (str): Users can optionally give their expectation from joining Provinear
    """

    email = models.EmailField(
        verbose_name='Email',
        primary_key=True,
        help_text='Enter your email address',
        validators=[EmailValidator(message="Enter a valid email address")]
    )
    name = models.CharField(
        verbose_name='Full name',
        help_text='Enter your full name',
        max_length=128,
        blank=False,
        null=False
    )
    expectation = models.TextField(
        verbose_name='Expectation',
        help_text='What is your expectation from joining Provinear?',
        blank=True,
        null=True
    )
    date_created = models.DateTimeField(
        verbose_name='Date Joined',
        auto_now_add=True,
        blank=True,
        null=False,
    )

    class Meta:
        db_table = 'waitlist'
        verbose_name = 'Wait List'
        verbose_name_plural = 'Wait Lists'

    def __str__(self):
        return f"WaitList<email='{self.email}', name='{self.name}'>"
