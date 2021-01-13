from django.utils.timezone import now
from rest_framework import serializers



class CWBSerializer(serializers.ModelSerializer):
    


    def get_days_since_created(self, obj):
        return (now() - obj.created).days
