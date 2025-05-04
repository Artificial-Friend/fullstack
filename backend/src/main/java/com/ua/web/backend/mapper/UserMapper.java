package com.ua.web.backend.mapper;

import com.ua.web.backend.dto.SignUpDto;
import com.ua.web.backend.dto.UserDto;
import com.ua.web.backend.entity.User;
import org.mapstruct.Mapper;
import org.mapstruct.Mapping;

@Mapper(componentModel = "spring")
public interface UserMapper {

    UserDto toUserDto(User user);

    @Mapping(target = "password", ignore = true)
    User signUpDtoToUser(SignUpDto signUpDto);
}
