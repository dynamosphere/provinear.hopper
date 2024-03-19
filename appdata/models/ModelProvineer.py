"""Copyright c.2024 Provinear@Dynamo

This module contains the model definition for Provinear's users (Provineer)

Author: Warith Adetayo
Date created: March 15, 2024
"""

from django.contrib.auth.base_user import AbstractBaseUser
from django.contrib.auth.validators import UnicodeUsernameValidator
from django.core.validators import EmailValidator
from django.db import models
from django.utils.translation import gettext_lazy as _

from account.managers import ProvineerManager
from appdata.models.AbstractModelExtendedPermissionsMixin import ExtendedPermissionsMixin


class Provineer(AbstractBaseUser, ExtendedPermissionsMixin):
    """This model represents the user model for Provinear call Provineer

    Attributes:
        email (CharField): The email address of user
        username (CharField): The unique username of user (although nullable)
        first_name (CharField): First name of user
        last_name (CharField): Last name of user
        email_verified (BooleanField): Specifies whether the email of user is verified or not
        is_staff(BooleanField): Specifies whether the user is a member of Provinear team
        is_active(BooleanField): Specifies whether the user is active or not
            inactive users cannot sign to their account

    """

    email = models.EmailField(
        verbose_name=_('Email'),
        primary_key=True,
        help_text=_('Enter your email address'),
        validators=[EmailValidator(message=_("Enter a valid email address"))]
    )
    username = models.CharField(
        verbose_name=_("Username"),
        max_length=128,
        unique=True,
        help_text=_(
            "Input username. 128 characters or fewer. Letters, digits and @/./+/-/_ only."
        ),
        validators=[UnicodeUsernameValidator()],
        error_messages={
            "unique": _("A user with that username already exists."),
        },
        blank=True,
        null=True
    )
    first_name = models.CharField(
        verbose_name=_("First name"),
        max_length=128,
        help_text=_("Enter your First name"),
        blank=True,
        null=True
    )
    last_name = models.CharField(
        verbose_name=_("Last name"),
        max_length=128,
        help_text=_("Enter your Last name"),
        blank=True,
        null=True
    )
    middle_name = models.CharField(
        verbose_name=_("Middle name"),
        max_length=128,
        help_text=_("Enter your Middle name"),
        blank=True,
        null=True
    )
    email_verified = models.BooleanField(
        _("Email Verified"),
        default=False,
        blank=True,
        null=False
    )
    is_staff = models.BooleanField(
        _("staff status"),
        default=False,
        help_text=_("Designates whether the user can log into this admin site."),
        blank=True,
        null=False,
    )
    is_active = models.BooleanField(
        _("active"),
        default=True,
        help_text=_(
            "Designates whether this user should be treated as active. "
            "Unselect this instead of deleting accounts."
        ),
        blank=True,
        null=False
    )
    date_of_birth = models.DateField(
        verbose_name=_("Date of Birth"),
        help_text=_("Enter your date of birth"),
        blank=True,
        null=True
    )
    date_joined = models.DateTimeField(
        verbose_name=_("Date joined"),
        auto_now_add=True,
        blank=True
    )
    date_modified = models.DateTimeField(
        verbose_name=_("Date modified"),
        auto_now=True,
        blank=True,
        null=True
    )

    class Meta:
        db_table = 'provineer'
        verbose_name = 'Provineer'
        verbose_name_plural = 'Provineers'

    USERNAME_FIELD = "email"
    REQUIRED_FIELDS = ['username']

    objects = ProvineerManager()

    def __str__(self):
        return f"Provineer<name='{self.first_name} {self.last_name}', date_joined='{self.date_joined}', verified='{self.email_verified}'>"
