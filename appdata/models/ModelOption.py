from django.db import models

from appdata.models.ModelOptionType import OptionType
from django.utils.translation import gettext_lazy as _


class Option(models.Model):
    """
    Note:
        Add Created by, date created and modified by field when required. It is
        omitted to reduce the amount of data needed to be stored in the database
    """

    option = models.CharField(
        verbose_name=_("Option"),
        max_length=128,
        primary_key=True
    )

    option_type = models.ForeignKey(
        OptionType, on_delete=models.CASCADE,
        verbose_name=_("Option Type")
    )

    def __str__(self):
        return self.option
