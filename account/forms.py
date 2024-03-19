from django.contrib.auth.forms import UserCreationForm, UserChangeForm

from appdata.models.ModelProvineer import Provineer


class AdminAddProvineerForm(UserCreationForm):
    class Meta:
        model = Provineer
        fields = "__all__"


class AdminEditProvineerForm(UserChangeForm):
    class Meta:
        model = Provineer
        fields = "__all__"
