import json
from printing.Printer import Printer
from flask import request


class Router(object):

    def __init__(self, app):
        self.appFlask = app
        self.printer = Printer()

    def manage_routes(self):

        app = self.appFlask
        printer = self.printer

        @app.route('/print', methods=['POST'])
        def print_tiket():
            data =json.loads( request.data.decode('utf8').replace("'", '"'))
            printer.print_ticket(data)
            #print(data["items"][0]["name"])
            return data
            
        # @app.route('/print/<turn>/<num>', methods=['POST'])
        # def print_ticket(turn,num):

        #     printer.print_ticket(turn,num)

        #     return json.dumps({
        #         'turn':turn,
        #         'number': num,
        #         'printed': True
        #     })
       
        # @app.route('/print/<num>', methods=['GET'])
        # def get_print_ticket(num):
        #     return json.dumps({
        #         'number': num,
        #         'printed': 'Fes POST'
        #     })

      