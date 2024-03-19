from django.contrib.auth.backends import ModelBackend


class Provineer(ModelBackend):
    """Authenticates against the Provineer's username or email o"""