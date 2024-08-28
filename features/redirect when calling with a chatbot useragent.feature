Feature: Redirect when calling with a chatbot useragent
	Scenario: Call with chatbot user-agent
		Given a useragent of "GPTBot"
		When the main website is called
		Then the respose is a redirect to "https://openai.com"
