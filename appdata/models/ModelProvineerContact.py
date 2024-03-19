from django.db import models
from django.utils.translation import gettext_lazy as _

from account.models import Provineer
from appdata.models.ModelOption import Option


class ProvineerContact(models.Model):

    CONTACT_TYPE_CHOICES = (
        ('email', 'Email'),
        ('phone', 'Phone'),
        ('social', 'Social'),
        ('website', 'Website')
    )

    # Network Provider
    # Email Provider
    # Social Provider

    # Type          Provider            Tag (SOCIAL_TAG, PHONE_TAG, EMAIL_TAG, GENERIC_TAG)
    # email         Gmail               PRIMARY
    # phone         MTN                 WHATSAPP, CALL, TELEGRAM
    # social        Facebook            CHAT
    # website       SELF                PORTFOLIO

    PROVIDER_CHOICES = (
        # Link (Social)
        ('twitter', 'Twitter'),
        ('facebook', 'Facebook'),
        ('instagram', 'Instagram'),
        ('linkedin', 'LinkedIn'),
        ('youtube', 'Youtube'),

        # Link (Website)
        ('github', 'Github'),
        ('portfolio', 'Portfolio'),
        ('personal', 'Personal'),

        # Phone Number (PHONE_TAG)
        ('telegram', 'Telegram'),
        ('whatsapp', 'WhatsApp'),
        ('primary', 'Primary'),
        ('main', 'Main'),
        ('work', 'Work'),
        ('mobile', 'Mobile'),
        ('home', 'Home')
    )

    contact = models.CharField(
        verbose_name=_("Contact"),
        max_length=512,
        primary_key=True
    )
    provineer = models.ForeignKey(
        Provineer,
        verbose_name=_("Provineer"),
        on_delete=models.CASCADE,
        null=False,
        blank=False
    )
    type = models.CharField(
        verbose_name=_("Contact type"),
        choices=CONTACT_TYPE_CHOICES,
        null=False,
        blank=False
    )
    provider = models.CharField(
        verbose_name=_("Contact Provider"),
        help_text=_("Pls enter your contact provider e.g Gmail for email or WhatsApp for "),
        blank=True,
        null=True,
        max_length=512
    )
    tags = models.ManyToManyField(Option, verbose_name=_("Tags"))

    sign_in_with = models.BooleanField(
        verbose_name=_("Sign in with contact"),
        default=False,
        blank=True,
        null=True
    )


