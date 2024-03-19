from django.db import models
from django.utils.translation import gettext_lazy as _

from django.contrib.auth.models import PermissionsMixin, Group, Permission


class ExtendedPermissionsMixin(PermissionsMixin):
    is_superuser = models.BooleanField(
        verbose_name=_("Superuser status"),
        default=False,
        help_text=_(
            "Designates that this user has all permissions without "
            "explicitly assigning them."
        ),
        blank=True
    )
    groups = models.ManyToManyField(
        Group,
        verbose_name=_("Groups"),
        blank=True,
        help_text=_(
            "The groups this provineer belongs to. A provineer will get all permissions "
            "granted to each of their groups."
        ),
        related_name="provineer_set",
        related_query_name="provineer",
    )
    user_permissions = models.ManyToManyField(
        Permission,
        verbose_name=_("Provineer permissions"),
        blank=True,
        help_text=_("Specific permissions for this provineer."),
        related_name="provineer_set",
        related_query_name="provineer",
    )

    class Meta:
        abstract = True
