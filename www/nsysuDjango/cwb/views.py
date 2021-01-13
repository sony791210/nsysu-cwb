
from django.shortcuts import render
from rest_framework import generics
from rest_framework.response import Response

from tool.apiResponseHelper import ApiResponseHelper
from rest_framework.generics import GenericAPIView



# Create your views here.

class CWBPoint(GenericAPIView):
    def get(self, request, *args, **krgs):
        idd=request.query_params.get('id', None)
        data={'test':123,'id':idd}
        return ApiResponseHelper.apiRespSuccess(data)

