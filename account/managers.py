from django.contrib.auth.base_user import BaseUserManager
from django.utils.translation import gettext_lazy as _


class ProvineerManager(BaseUserManager):
    """User model manager where email is the PK instead of usernames for authentication"""

    def __do_create(self, email, password, **extra_fields):
        if not email:
            raise ValueError(_("Email is required"))
        email = self.normalize_email(email)

        user = self.model(email=email, **extra_fields)
        user.set_password(password)
        user.save(using=self._db)

        return user

    def create_user(self, email, password, **extra_fields):
        extra_fields.pop('is_staff', None)      # Ensuring a normal user is created with this function
        extra_fields.pop('is_superuser', None)
        return self.__do_create(email, password, **extra_fields)

    def create_superuser(self, email, password, **extra_fields):
        extra_fields['is_staff'] = True
        extra_fields['is_superuser'] = True
        return self.__do_create(email, password, **extra_fields)
