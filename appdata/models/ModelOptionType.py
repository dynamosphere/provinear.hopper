from django.utils.translation import gettext_lazy as _
from django.db import models

from appdata.models.ModelProvineer import Provineer


class OptionType(models.Model):
    """
    Note:
        Add Created by, date created and modified by field when required. It is
        omitted to reduce the amount of data needed to be stored in the database.
        Remember: Avoid circular dependencies between this, Provineer and ProvineerContact
    """
    option_type = models.CharField(
        verbose_name=_("Option Type name"),
        max_length=128,
        primary_key=True
    )
    parent = models.ForeignKey(
        'OptionType',
        on_delete=models.SET_NULL,
        null=True,
        blank=True
    )
    description = models.CharField(
        verbose_name=_("Description of option type"),
        max_length=512,
        blank=True,
        null=True
    )

    def __str__(self):
        return self.option_type
