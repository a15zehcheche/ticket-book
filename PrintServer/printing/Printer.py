import Constants
from .Tiket import tiket


class Printer(object):

    def __init__(self):
        self.e_printer = tiket()

    def print_ticket(self,data):
        self.e_printer.print_ticket(data)
        
        
