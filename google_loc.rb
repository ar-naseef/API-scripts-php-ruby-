# The program takes the city or the country as the input.
# And output is the Latitude and Longitude of the input.

require 'net/http'
require 'json'
# require 'pp'

print "enter the city to find the coordinates: "
city = gets
url = "http://maps.googleapis.com/maps/api/geocode/json?&address="+city
master_url = URI(url)

res = Net::HTTP.get(master_url)
json_res = JSON.parse(res)

# pp json_res
puts
k = json_res['results'][0]['address_components'].size
# puts k
for i in 0..(k-1)
	if (json_res['results'][0]['address_components'][i]['types'].include?('locality'))
		puts "city: "+json_res['results'][0]['address_components'][i]['long_name']
	end
end

# puts "city: "+json_res['results'][0]['address_components'][0]['long_name']

# print "country: " #+json_res['results'][0]['address_components'][3]['long_name']
for i in 0..(k-1)
	if (json_res['results'][0]['address_components'][i]['types'].include?('country'))
		puts "country: "+json_res['results'][0]['address_components'][i]['long_name']
	end
end

puts "Latitude: "+(json_res['results'][0]['geometry']['location']['lat']).to_s
puts "Longitude: "+(json_res['results'][0]['geometry']['location']['lng']).to_s

