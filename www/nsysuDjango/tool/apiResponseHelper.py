from rest_framework.response import Response

class ApiResponseHelper:

    def apiRespSuccess(data , message = 'success'):
        successCode='00000'
        return Response({'code':successCode,'message':message,'data':data})

    def apiRespFail(code, message, data = None):
        return Response({'code':code,'message':message,'data':data})