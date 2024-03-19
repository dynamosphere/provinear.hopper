from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from django.contrib.auth.forms import AdminPasswordChangeForm
from django.utils.translation import gettext_lazy as _

from account.forms import AdminAddProvineerForm, AdminEditProvineerForm
from appdata.models.ModelProvineer import Provineer


class ProvineerAdmin(UserAdmin):
    form = AdminEditProvineerForm
    add_form = AdminAddProvineerForm
    model = Provineer

    list_display = (
        "email",
        "username",
        "first_name",
        "last_name",
        "is_staff",
        "is_active",
        "is_superuser",
        "date_joined",
        "last_login",
        "email_verified"
    )
    list_filter = ("email_verified", "is_staff", "is_superuser", "is_active", "groups")
    search_fields = ("username", "first_name", "last_name", "email")


    fieldsets = (
        (None, {"fields": ("username", "password")}),
        (_("Personal info"), {"fields": ("first_name", "last_name", "email")}),
        (
            _("Permissions"),
            {
                "fields": (
                    "is_active",
                    "is_staff",
                    "is_superuser",
                    "groups",
                    "user_permissions",
                ),
            },
        ),
        (_("Important dates"), {"fields": ("last_login", "date_joined")}),
    )
    add_fieldsets = (
        (
            None,
            {
                "classes": ("wide",),
                "fields": ("username", "password1", "password2"),
            },
        ),
    )


    ordering = ("username",)
    filter_horizontal = (
        "groups",
        "user_permissions",
    )


